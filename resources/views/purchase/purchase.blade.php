@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h3 class="text-black-50">Purchase Management</h3>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#purchaseAdd">
          <i class="fa fa-plus"></i>  Add
        </button>

        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table id="tablePurchase" class="table table-hover table-bordered" width="100%" style="font-size: 13px">
                        <thead>
                            <tr class="text-center bg-primary">
                                <th class="text-center">No</th>
                                <th class="text-center">Kode Purchase</th>
                                <th class="text-center">Supplier</th>
                                <th class="text-center">Description</th>
                                <th class="text-center">Status</th>
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
        <div class="modal fade" id="purchaseAdd" tabindex="-1" aria-labelledby="purchaseAddLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title" id="purchaseAddLabel">Add Product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-23">
                                    <form action="#" id="formadd">
                                        @csrf
                                        <div class="form-group row">
                                            <div class="col-sm-3">
                                                <label for="">Supplier</label>
                                            </div>
                                            <div class="col-sm-5">
                                                <select name="supplierId" id="supplierId"
                                                    class="form-control select2" >
                                                    <option value="0" disabled selected>Pilih</option>
                                                    @forelse ($supplier as $key=>$item)
                                                        <option value="{{$key}}">{{$item}}</option>
                                                    @empty
                                                        <option value="0" disabled>Data Not Found</option>
                                                    @endforelse
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-3">
                                                <label for="">Description</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <textarea name="description" id="description" cols="20" rows="10" class="form-control"></textarea>
                                            </div>
                                        </div>


                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-success" onclick="addPurchase()"> <i class="fa fa-save"></i> Save changes</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="purchaseEdit" tabindex="-1" aria-labelledby="purchaseEditLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title" id="purchaseEditLabel">Edit Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-23">
                                <form action="#" id="formedit">
                                    @csrf
                                    <input type="hidden" name="purchaseId" id="purchaseId_e">
                                    <input type="hidden" name="kodePurchase" id="kodePurchase_e">
                                    <div class="form-group row">
                                        <div class="col-sm-3">
                                            <label for="">Supplier</label>
                                        </div>
                                        <div class="col-sm-5">
                                            <select name="supplierId" id="supplierId_e" class="form-control select2" >
                                                <option value="0" disabled selected>Pilih</option>
                                                @forelse ($supplier as $key=>$item)
                                                    <option value="{{$key}}">{{$item}}</option>
                                                @empty
                                                    <option value="0" disabled>Data Not Found</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-3">
                                            <label for="">Description</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <textarea name="description" id="description_e" cols="20" rows="10" class="form-control"></textarea>
                                        </div>
                                    </div>


                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" onclick="editPurchase()"> <i class="fa fa-save"></i> Save changes</button>
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

        table = $('#tablePurchase').DataTable({

            ajax: {
                url: `/listDataPurchase`,
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
                { data:'kodePurchase', className: 'text-left'},
                { data:'supplier.supplierName', className: 'text-left'},
                { data:'description', className: 'text-left'},
                { data:null, className: 'text-center', render: function (data) {

                        let status = '';

                        if(data.status==1){
                            status='Open';
                        }else if(data.status==2){
                            status='Checking'
                        }else if(data.status==3){
                            status='Checked'
                        }else if(data.status==4){
                            status='Ongoing'
                        }else if(data.status==5){
                            status='Close'
                        }

                        return status;
                    }
                },
                { data:null, className: 'text-center', render: function (data) {

                        let tampilBtn = '';

                        const params = JSON.stringify(data);
                        tampilBtn += `

                            <button type="button" onclick='showDataEdit(${params})' value=""
                                class="btn btn-sm btn-warning" > <i class="fa fa-edit"></i>
                                Edit
                            </button>
                            <button type="button" onclick="deleteProduct(${data.purchaseId})" value="" class="btn btn-sm btn-danger" >
                                <i class="fa fa-trash"></i>
                                Delete
                            </button>
                            <a href="{{url('/purchase/detail/${data.purchaseId}')}}" class="btn btn-sm btn-info">
                                <i class="fa fa-eye"></i>
                                Detail
                            </a>
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
        $('#purchaseId_e').val(data.purchaseId);
        $('#kodePurchase_e').val(data.kodePurchase);
        $('#description_e').val(data.description);
        $('#supplierId_e').val(data.supplierId).select2().trigger('select');

        $('#purchaseEdit').modal('show');
    }

    function addPurchase()
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

                    let formdata=$('#formadd').serialize();
                    $.ajax({
                        type: "POST",
                        url: "{{url('/addDataPurchase')}}",
                        data: formdata,
                        dataType: "json",
                        success: function (response) {

                            if(response.status==200){
                                Swal.fire(
                                    'Saved!',
                                    response.message,
                                    'success'
                                )
                                formreset()
                                $('#purchaseAdd').modal('hide');
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

    function editPurchase()
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

                    let formdata=$('#formedit').serialize();
                    $.ajax({
                        type: "POST",
                        url: "{{url('/updateDataPurchase')}}",
                        data: formdata,
                        dataType: "json",
                        success: function (response) {

                            if(response.status==200){
                                Swal.fire(
                                    'Saved!',
                                    response.message,
                                    'success'
                                )

                                $('#purchaseEdit').modal('hide');
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

    function deleteProduct(purchaseId)
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
                        url: "{{url('/deleteDataPurchase')}}",
                        data: {purchaseId},
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

