@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h3 class="text-black-50">Sub Menu Management</h3>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#subMenuAdd">
          <i class="fa fa-plus"></i>  Add
        </button>
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table id="tableSubMenu" class="table table-hover table-bordered" width="100%" style="font-size: 13px">
                        <thead>
                            <tr class="text-center bg-primary">
                                <th class="text-center">No</th>
                                <th class="text-center">Sub Menu</th>
                                <th class="text-center">Sub Menu Icon</th>
                                <th class="text-center">Sub Menu Url</th>
                                <th class="text-center">Menu Parent</th>
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
        <div class="modal fade" id="subMenuAdd" tabindex="-1" aria-labelledby="subMenuAddLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title" id="subMenuAddLabel">Add Menu</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-23">
                                    <form action="#" id="formadd">
                                        @csrf
                                        <div class="form-group row">
                                            <div class="col-sm-3">
                                                <label for="">Sub Menu Name</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input id="subMenuName" name="subMenuName" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-3">
                                                <label for="">Sub Menu Icon</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input id="subMenuIcon" name="subMenuIcon" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-3">
                                                <label for="">Sub Menu Url</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input id="subMenuUrl" name="subMenuUrl" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-3">
                                                <label for="">Menu Parent</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <select name="menuId" id="menuId"
                                                    class="form-control select2" >
                                                    <option value="0" disabled>Pilih</option>
                                                    @forelse ($menu as $key=>$item)
                                                        <option value="{{$key}}">{{$item}}</option>
                                                    @empty
                                                        <option value="0" disabled>Data Not Found</option>
                                                    @endforelse
                                                </select>
                                            </div>
                                        </div>


                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-success" onclick="addSubmenu()"> <i class="fa fa-save"></i> Save changes</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="subMenuEdit" tabindex="-1" aria-labelledby="subMenuEditLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title" id="subMenuEditLabel">Edit Sub Menu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-23">
                                <form action="#" id="formedit">
                                    @csrf
                                    <div class="form-group row">
                                            <div class="col-sm-3">
                                                <label for="">Sub Menu Name</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input id="subMenusId_e" name="subMenusId" type="hidden" >
                                                <input id="subMenuName_e" name="subMenuName" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-3">
                                                <label for="">Sub Menu Icon</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input id="subMenuIcon_e" name="subMenuIcon" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-3">
                                                <label for="">Sub Menu Url</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input id="subMenuUrl_e" name="subMenuUrl" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-3">
                                                <label for="">Menu Parent</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <select name="menuId" id="menuId_e"
                                                    class="form-control select2" >
                                                    <option value="0" disabled>Pilih</option>
                                                    @forelse ($menu as $key=>$item)
                                                        <option value="{{$key}}">{{$item}}</option>
                                                    @empty
                                                        <option value="0" disabled>Data Not Found</option>
                                                    @endforelse
                                                </select>
                                            </div>
                                        </div>



                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" onclick="editSubmenu()"> <i class="fa fa-save"></i> Save changes</button>
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

        table = $('#tableSubMenu').DataTable({

            ajax: {
                url: `/listDataSubMenu`,
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
                { data:'subMenuName', className: 'text-left'},
                { data:'subMenuIcon', className: 'text-center'},
                { data:'subMenuUrl', className: 'text-center'},
                { data:'menus.menuName', className: 'text-center'},
                { data:null, className: 'text-center', render: function (data) {

                        let tampilBtn = '';

                        const params = JSON.stringify(data);
                        tampilBtn += `
                            <button type="button" onclick='showDataEdit(${params})' value=""
                                class="btn btn-sm btn-warning" > <i class="fa fa-edit"></i> Edit</button>
                            <button type="button" onclick="deleteSubmenu(${data.subMenusId})" value="" class="btn btn-sm btn-danger" > <i class="fa fa-trash"></i> Delete</button>
                        `;

                        return tampilBtn;
                    }
                },
            ],

        });

    });

    function formreset()
    {
        $("#formadd").trigger("reset");
    }

    function showDataEdit(data)
    {
        $('#subMenusId_e').val(data.subMenusId);
        $('#subMenuName_e').val(data.subMenuName);
        $('#subMenuIcon_e').val(data.subMenuIcon);
        $('#subMenuUrl_e').val(data.subMenuUrl);
        $('#menuId_e').val(data.menuId).select2().trigger('select');
        $('#subMenuEdit').modal('show');
    }

    function addSubmenu()
    {
        Swal.fire({
            title: 'Are you sure to save data?',
            text: "Please make sure your input is correct!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
            }).then((result) => {
                Swal.showLoading()
                if (result.isConfirmed) {

                    let subMenuName=$('#subMenuName').val();
                    let subMenuIcon=$('#subMenuIcon').val();
                    let subMenuUrl=$('#subMenuUrl').val();
                    let menuId=$('#menuId').val();
                    $.ajax({
                        type: "POST",
                        url: "{{url('/addDataSubMenu')}}",
                        data: {subMenuName,subMenuIcon,menuId,subMenuUrl},
                        dataType: "json",
                        success: function (response) {

                            if(response.status==200){
                                Swal.fire(
                                    'Saved!',
                                    response.message,
                                    'success'
                                )
                                formreset()
                                $('#subMenuAdd').modal('hide');
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

    function editSubmenu()
    {
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

                    let menuId=$('#menuId_e').val();
                    let subMenuName=$('#subMenuName_e').val();
                    let subMenuIcon=$('#subMenuIcon_e').val();
                    let subMenuUrl=$('#subMenuUrl_e').val();
                    let subMenusId=$('#subMenusId_e').val();

                    $.ajax({
                        type: "POST",
                        url: "{{url('/updateDataSubMenu')}}",
                        data: {subMenuName,subMenuIcon,menuId,subMenusId,subMenuUrl},
                        dataType: "json",
                        success: function (response) {

                            if(response.status==200){
                                Swal.fire(
                                    'Saved!',
                                    response.message,
                                    'success'
                                )

                                $('#subMenuEdit').modal('hide');
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

    function deleteSubmenu(subMenusId)
    {
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
                        url: "{{url('/deleteDataSubMenu')}}",
                        data: {subMenusId},
                        dataType: "json",
                        success: function (response) {

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

