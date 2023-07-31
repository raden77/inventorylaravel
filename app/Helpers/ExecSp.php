<?php

use Illuminate\Support\Facades\Log;

if(!function_exists('ExecSP')) {
    function ExecSP($SP = NULL, $params = []) {
        try {
            // handel jika ada parameter
            if(count($params)) {
                $lastIndex = array_key_last($params);
                $tempParams = '';
                foreach($params as $key => $value) {
                    $tempParams .= "?";
                    if($key != $lastIndex) {
                        $tempParams .= ",";
                    }
                }

                $exec = DB::select("EXEC {$SP} {$tempParams}", $params);
                return $exec;
            }
            else {
                $exec = DB::select("EXEC {$SP}");
                return $exec;
            }
        } catch (\Throwable $th) {
            $result = [(object)[
                'respon' =>  $th->getMessage(),
                // 'respon' =>  "Process failed please contact Developer",
                'responCode' => 3
            ]];
            Log::info('Database Error In helper ExecSP : '.$th->getMessage());
            return $result;
        }
    }
}

if(!function_exists('ExecSP_withResponCode')) {
    function ExecSP_withResponCode($SP = NULL, $params = []) {
        try {
            $exec = null;
            // handel jika ada parameter
            if(count($params)) {
                $lastIndex = array_key_last($params);
                $tempParams = '';
                foreach($params as $key => $value) {
                    $tempParams .= "?";
                    if($key != $lastIndex) {
                        $tempParams .= ",";
                    }
                }

                $exec = DB::select("EXEC {$SP} {$tempParams}", $params);
            }
            else {
                $exec = DB::select("EXEC {$SP}");
            }

            if ($exec && isset($exec[0]->responCode)) {
                return (array) $exec[0];
            }

            return [
                'data' => $exec,
                'responCode' => 1,
                'respon' => 'SP sukses.',
            ];
        } catch (\Throwable $th) {
            $result = [
                'data' => [],
                'responCode' => 0,
                'respon' => $th->getMessage(),
                // 'respon' => "Process failed please contact Developer",
            ];
            Log::info('Database Error In helper ExecSP_withResponCode : '.$th->getMessage());
            return $result;
        }
    }
}

if(!function_exists('ExecSPParamAssocRow')) {
    function ExecSPParamAssocRow($storedProcedure = NULL, $paramsToModel = [])
	{
        try {
            $param  = "";
            $params = "";
            $realParamsAssoc = array();
            $statusParams = "";
            $respon = "";

            $data = DB::select("SELECT schema_name(obj.schema_id) as schema_name,
                obj.name as procedure_name,
                case type
                when 'P' then 'SQL Stored Procedure'
                when 'X' then 'Extended stored procedure'
                end as type,
                -- par.parameters as parameters
                substring(par.parameters, 0, len(par.parameters)) as parameters
                -- mod.definition
                from sys.objects obj
                join sys.sql_modules mod
                on mod.object_id = obj.object_id
                cross apply (select p.name + ' ' + TYPE_NAME(p.user_type_id) + ', '
                from sys.parameters p
                where p.object_id = obj.object_id
                and p.parameter_id != 0
                for xml path ('') ) par (parameters)
                where obj.type in ('P', 'X')
                AND obj.name = '$storedProcedure'
                order by schema_name,
                procedure_name;");

            if ($data) {
                $parameters = explode(",", $data[0]->parameters);
                if ($data[0]->parameters != null) {

                    $lastKey = array_key_last($parameters);
                    foreach ($parameters as $key => $val) {
                        $CheckParams = explode(" ", trim($val));
                        $param = str_replace("@", "", $CheckParams[0]);
                        $params .= "?, ";
                        if (isset($paramsToModel[$param])) {
                            $realParamsAssoc[$param] = $paramsToModel[$param];
                        } else {
                            if(($lastKey - 1) == $key) {
                                $respon .= str_replace(" @", "", $val) . " => NULL";
                            } else {
                                $respon .= str_replace(" @", "", $val) . " => NULL, ";
                            }
                        }
                    }

                    if (count($realParamsAssoc) != count($parameters)) {
                        $result = [(object)[
                            'respon' => $respon,
                            'responCode' => 0,
                            'data' => NULL
                        ]];
                        return $result;
                    }
                    $params = substr($params, 0, -2);
                }

                $realParams = array_values($realParamsAssoc);
                $resultData = DB::select("EXEC $storedProcedure $params",  $realParams);
                if(count($resultData) > 0) {
                    $result = [(object)[
                        'respon' => 'Berhasil Eksekusi Store Procedure',
                        'responCode' => 1,
                        'data' => $resultData
                    ]];
                } else {
                    $result = [(object)[
                        'respon' => 'Data Kosong',
                        'responCode' => 0,
                        'data' => NULL
                    ]];
                }

            } else {
                $result = [(object)[
                    'respon' => "Stored Procedure $storedProcedure Tidak Ditemukan",
                    'responCode' => 0,
                    'data' => NULL
                ]];
            }
        }catch (\Throwable $th) {
            $result = [(object)[
                'respon' =>  $th->getMessage(),
                // 'respon' =>  "Process failed please contact Developer",
                'responCode' => 500
            ]];
            Log::info('Database Error In helper ExecSPParamAssocRow : '.$th->getMessage());
        }
        return $result;
    }
}

if(!function_exists('ExecSPParamAssoc')) {
    function ExecSPParamAssoc($storedProcedure = NULL, $paramsToModel = [])
	{
        try {
            $param  = "";
            $params = "";
            $realParamsAssoc = array();
            $statusParams = "";
            $respon = "";

            $data = DB::select("SELECT schema_name(obj.schema_id) as schema_name,
                obj.name as procedure_name,
                case type
                when 'P' then 'SQL Stored Procedure'
                when 'X' then 'Extended stored procedure'
                end as type,
                -- par.parameters as parameters
                substring(par.parameters, 0, len(par.parameters)) as parameters
                -- mod.definition
                from sys.objects obj
                join sys.sql_modules mod
                on mod.object_id = obj.object_id
                cross apply (select p.name + ' ' + TYPE_NAME(p.user_type_id) + ', '
                from sys.parameters p
                where p.object_id = obj.object_id
                and p.parameter_id != 0
                for xml path ('') ) par (parameters)
                where obj.type in ('P', 'X')
                AND obj.name = '$storedProcedure'
                order by schema_name,
                procedure_name;");

            if ($data) {
                $parameters = explode(",", $data[0]->parameters);
                if ($data[0]->parameters != null) {

                    $lastKey = array_key_last($parameters);
                    $index = 1;
                    foreach ($parameters as $key => $val) {
                        $CheckParams = explode(" ", trim($val));
                        $param = str_replace("@", "", $CheckParams[0]);
                        $params .= "?, ";
                        if (isset($paramsToModel[$param])) {
                            $realParamsAssoc[$param] = $paramsToModel[$param];
                        } else {
                            if(($lastKey - 1) == $key) {
                                $respon .= str_replace(" @", "", $val) . " => NULL";
                            } else {
                                $respon .= str_replace(" @", "", $val) . " => NULL, ";
                            }
                        }
                        $index++;
                    }

                    if (count($realParamsAssoc) != count($parameters)) {
                        $result = [(object)[
                            'respon' => $respon,
                            'responCode' => 2
                        ]];
                        return $result;
                    }

                    $params = substr($params, 0, -2);
                }

                $realParams = array_values($realParamsAssoc);
                $result = DB::select("EXEC $storedProcedure $params",  $realParams);
                return $result;

            } else {
                $result = [(object)[
                    'respon' => "Stored Procedure $storedProcedure Tidak Ditemukan",
                    'responCode' => 2
                ]];
                return $result;
            }
        }catch (\Throwable $th) {
            $result = [(object)[
                'respon' =>  $th->getMessage(),
                // 'respon' =>  "Process failed please contact Developer",
                'responCode' => 500,
                'data' => NULL
            ]];
            Log::info('Database Error In Helper ExecSPParamAssoc : '.$th->getMessage());
        }
        return $result;
	}
}

if(!function_exists('ExecSPNewPatch')) {
	function ExecSPNewPatch($SP = NULL, $custom_params = [], $totalParams = 0) {
		try {

			$params = "";
			$request = [];
			$param_req = [];

			// Cache Data If Wont In Here
			if (cache()->has("CacheSP_" . $SP)) {

				$data = cache()->get("CacheSP_" . $SP);
				// return dd($data);
			} else {

				$data = DB::select("SELECT schema_name(obj.schema_id) as schema_name, obj.name as procedure_name, case type when 'P' then 'SQL Stored Procedure' when 'X' then 'Extended stored procedure' end as type, substring(par.parameters, 0, len(par.parameters)) as parameters from sys.objects obj join sys.sql_modules mod on mod.object_id = obj.object_id cross apply (select p.name + ' ' + TYPE_NAME(p.user_type_id) + ', ' from sys.parameters p where p.object_id = obj.object_id and p.parameter_id != 0 for xml path ('') ) par (parameters) where obj.type in ('P', 'X') AND obj.name = ? order by schema_name, procedure_name;", [$SP]);


				$data = @$data[0];
				// Cache Data If Wont In Here
				cache( [ "CacheSP_" . $SP => $data ] , now()->addMinutes(10) );
				// return dd($data);
			}

			if ($data) {
				$parameters = explode(", ", $data->parameters);
				foreach ($parameters as $key => $val) {
					$check_params = explode(" ", trim($val));
					$param = str_replace("@", "", $check_params[0]);

					$request[$key] = isset($custom_params[$param]) ? $custom_params[$param] : request($param);

					if ($request[$key] != null) {
						$param_req[$param] = $request[$key];
						$totalParams++;
					}

					$params .= "?, ";
				}

				if ((int)$totalParams != count($parameters)) {
					return dd([
						'error'    => true,
						'messages' => "Parameter Stored Procedure Tidak Lengkap",
						"data"     => [
							'name_sp'            => $data->procedure_name,
							'parameters_sp'      => $parameters,
							'parameters_request' => $request,
							'request'            => $param_req,
						],
					]);
				}

				$params = substr($params, 0, -2);

				if ($totalParams==0) {
					return DB::select("EXEC {$SP}");
				}

				return DB::select("EXEC {$SP} {$params}", $request);
			}

			return dd([
				'error'    => true,
				'messages' => "Parameter Stored Procedure Tidak Ditemukan",
				"data"     => [
					'name_sp'            => $SP,
					'parameters_sp'      => $params,
					'parameters_request' => $request,
					'request'            => $param_req,
				],
			]);

		} catch (\Throwable $th) {
			return dd([
				'error'    => true,
				'messages' => $th->getMessage(),
				"data"     => [
					'name_sp'            => null,
					'parameters_sp'      => null,
					'parameters_request' => null,
					'request'            => null,
				],
			]);
		}
	}
}
