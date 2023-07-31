@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h3 class="text-black-50">Unit Conversion</h3>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#unitAdd">
          <i class="fa fa-plus"></i>  Add
        </button>
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table id="tableUnitConversion" class="table table-hover table-bordered" width="100%" style="font-size: 13px">
                        <thead>
                            <tr class="text-center bg-primary">
                                <th class="text-center">No</th>
                                <th class="text-center">From Unit</th>
                                <th class="text-center">To Unit</th>
                                <th class="text-center">Ratio</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="unitAdd" tabindex="-1" aria-labelledby="unitAddLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title" id="unitAddLabel">Add Unit Conversion</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-23">
                                    <form action="#" id="formadd">
                                        @csrf
                                        <div class="form-group row">
                                            <div class="col-sm-3">
                                                <label for="">From Unit</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <select name="fromUnit" id="fromUnit"
                                                    class="form-control select2" >
                                                    <option value="0" disabled>Pilih</option>
                                                    @forelse ($unit as $key=>$item)
                                                        <option value="{{$key}}">{{$item}}</option>
                                                    @empty
                                                        <option value="0" disabled>Data Not Found</option>
                                                    @endforelse
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-3">
                                                <label for="">To Unit</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <select name="toUnit" id="toUnit"
                                                    class="form-control select2" >
                                                    <option value="0" disabled>Pilih</option>
                                                    @forelse ($unit as $key=>$item)
                                                        <option value="{{$key}}">{{$item}}</option>
                                                    @empty
                                                        <option value="0" disabled>Data Not Found</option>
                                                    @endforelse
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-3">
                                                <label for="">Convesion Ratio</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input id="ratio" name="ratio" type="number" class="form-control">
                                            </div>
                                        </div>


                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-success" onclick="addUnit()"> <i class="fa fa-save"></i> Save changes</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="unitEdit" tabindex="-1" aria-labelledby="unitAddLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title" id="unitAddLabel">Edit Unit</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-23">
                                <form action="#" id="formedit">
                                    @csrf
                                    <div class="form-group row">
                                        <div class="col-sm-3">
                                            <label for="">From Unit</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="hidden" name="unitConversionId" id="unitConversionId_e">
                                            <select name="fromUnit" id="fromUnit_e"
                                                class="form-control select2" >
                                                <option value="0" disabled>Pilih</option>
                                                @forelse ($unit as $key=>$item)
                                                    <option value="{{$key}}">{{$item}}</option>
                                                @empty
                                                    <option value="0" disabled>Data Not Found</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-3">
                                            <label for="">To Unit</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <select name="toUnit" id="toUnit_e"
                                                class="form-control select2" >
                                                <option value="0" disabled>Pilih</option>
                                                @forelse ($unit as $key=>$item)
                                                    <option value="{{$key}}">{{$item}}</option>
                                                @empty
                                                    <option value="0" disabled>Data Not Found</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-3">
                                            <label for="">Convesion Ratio</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input id="ratio_e" name="ratio" type="number" class="form-control">
                                        </div>
                                    </div>


                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" onclick="editUnit()"> <i class="fa fa-save"></i> Save changes</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
<script>

    let table;

    $(document).ready(function () {

        table = $('#tableUnitConversion').DataTable({

            ajax: {
                url: `/listDataUnitConversion`,
                dataSrc: (json) => {
                    // console.log(json);
                    let nomor=0;
                    json.forEach((row, idx) => {
                        nomor ++;
                        row.nomor = nomor;
                    });
                    return json;
                }
            },
            columns:[
                { data:'nomor', className: 'text-center'},
                { data:'from_unit.unitName', className: 'text-center'},
                { data:'to_unit.unitName', className: 'text-center'},
                { data:'ratio', className: 'text-center'},
                { data:null, className: 'text-center', render: function (data) {

                        let tampilBtn = '';

                        const params = JSON.stringify(data);
                        tampilBtn += `
                            <button type="button" onclick='showDataEdit(${params})' value=""
                                class="btn btn-sm btn-warning" > <i class="fa fa-edit"></i> Edit</button>
                            <button type="button" onclick="deleteUnit(${data.unitConversionId})" value="" class="btn btn-sm btn-danger" >
                                <i class="fa fa-trash"></i> Delete</button>
                        `;

                        return tampilBtn;
                    }
                },
            ],

        });
    });

    function formreset(){
        $("#formadd").trigger("reset");
    }


    function showDataEdit(data)
    {
        $('#unitConversionId_e').val(data.unitConversionId);
        $('#fromUnit_e').val(data.fromUnit).select2().trigger('select');
        $('#toUnit_e').val(data.toUnit).select2().trigger('select');
        $('#ratio_e').val(data.ratio);
        $('#unitEdit').modal('show');
    }

    function addUnit(){
        Swal.fire({
            title: 'Are you sure to save data?',
            text: "Please make sure your input is correct!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {

                    let fromUnit=$('#fromUnit').val();
                    let toUnit=$('#toUnit').val();
                    let ratio=$('#ratio').val();

                    $.ajax({
                        type: "POST",
                        url: "{{url('/addDataUnitConversion')}}",
                        data: {fromUnit,toUnit,ratio},
                        dataType: "json",
                        success: function (response) {

                            console.log(response);

                            if(response.status==200){
                                Swal.fire(
                                    'Saved!',
                                    response.message,
                                    'success'
                                )
                                formreset()
                                $('#unitAdd').modal('hide');
                                table.ajax.reload(null, false);
                            }else{
                                Swal.fire(
                                    'Failed!',
                                    response.message,
                                    'warning'
                                )
                            }


                        },
                        error: function(error) {

                            Swal.fire(
                                'Failed!',
                                error.responseJSON.message,
                                'error'
                            )
                            return false;
                        }
                    });


                }
        })
    }

    function editUnit(){
        Swal.fire({
            title: 'Are you sure to save data?',
            text: "Please make sure your input is correct!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {

                    let unitConversionId=$('#unitConversionId_e').val();
                    let fromUnit=$('#fromUnit_e').val();
                    let toUnit=$('#toUnit_e').val();
                    let ratio=$('#ratio_e').val();

                    $.ajax({
                        type: "POST",
                        url: "{{url('/updateDataUnitConversion')}}",
                        data: {unitConversionId,fromUnit,toUnit,ratio},
                        dataType: "json",
                        success: function (response) {

                            if(response.status==200){
                                Swal.fire(
                                    'Saved!',
                                    response.message,
                                    'success'
                                )

                                $('#unitEdit').modal('hide');
                                table.ajax.reload(null, false);
                            }else{
                                Swal.fire(
                                    'Failed!',
                                    response.message,
                                    'warning'
                                )
                            }


                        },
                        error: function(error) {

                            Swal.fire(
                                'Failed!',
                                error.responseJSON.message,
                                'error'
                            )
                            return false;
                        }
                    });


                }
        })
    }

    function deleteUnit(unitConversionId){
        Swal.fire({
            title: 'Are you sure to delete data?',
            text: "",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        type: "POST",
                        url: "{{url('/deleteDataUnitConversion')}}",
                        data: {unitConversionId},
                        dataType: "json",
                        success: function (response) {

                            // console.log(response);

                            if(response.status==200){
                                Swal.fire(
                                    'Deleted!',
                                    response.message,
                                    'success'
                                )

                                table.ajax.reload(null, false);
                            }else{
                                Swal.fire(
                                    'Failed!',
                                    response.message,
                                    'warning'
                                )
                            }


                        },
                        error: function(error) {

                            Swal.fire(
                                'Failed!',
                                error.responseJSON.message,
                                'error'
                            )
                            return false;
                        }
                    });


                }
        })
    }
</script>
@endsection

