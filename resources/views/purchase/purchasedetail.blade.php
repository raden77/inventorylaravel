@extends('layouts.app')

@section('content')
@php
    $statusinfo='';

    if($purchaseinfo->status==1){
        $statusinfo='Open';
    }else if($purchaseinfo->status==2){
        $statusinfo='Checking';
    }else if($purchaseinfo->status==3){
        $statusinfo='Checked';
    }else if($purchaseinfo->status==4){
        $statusinfo='Ongoing';
    }else if($purchaseinfo->status==5){
        $statusinfo='Close';
    }
@endphp
    <div class="container-fluid">
        <h3 class="text-black-50">Purchase Detail</h3>
        <div class="card">
            <div class="card-header">
                <h6 class="text-end">Status&nbsp;:&nbsp;<span class="badge bg-primary">{{$statusinfo}}</span></h6>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-sm-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="140">Kode Purchase</th>
                                <td width="10">:</td>
                                <td>{{$purchaseinfo->kodePurchase}}</td>
                            </tr>
                            <tr>
                                <th>Supplier</th>
                                <td>:</td>
                                <td>{{$purchaseinfo->supplier->supplierName}}</td>
                            </tr>

                        </table>
                    </div>
                    <div class="col-sm-6">
                        <table  class="table table-borderless">
                            <tr>
                                <th width="140">Description</th>
                                <td width="10">:</td>
                                <td>{{$purchaseinfo->description}}</td>
                            </tr>
                        </table>
                    </div>

                </div>
                <hr class="bg-dark">
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#itemAdd">
                    <i class="fa fa-plus"></i>  Add
                </button>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table id="tableset" class="table table-hover table-bordered" width="100%" style="font-size: 13px">
                                <thead>
                                    <tr class="text-center bg-primary">
                                        <th class="text-center">No</th>
                                        <th class="text-center">Product</th>
                                        <th class="text-center">Unit</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- Modal -->
        <div class="modal fade" id="itemAdd" tabindex="-1" aria-labelledby="itemAddLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title" id="itemAddLabel">Add Item</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-23">
                                    <form action="#" id="formadd">
                                        @csrf

                                        <div class="form-group row">
                                            <div class="col-sm-3">
                                                <label for="">Product</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <select name="productId" id="productId"
                                                    class="form-control select2" >
                                                    <option value="0" disabled selected>Pilih</option>
                                                    @forelse ($product as $key=>$item)
                                                        <option value="{{$key}}">{{$item}}</option>
                                                    @empty
                                                        <option value="0" disabled>Data Not Found</option>
                                                    @endforelse
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-3">
                                                <label for="">Unit</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <select name="unitId" id="unitId"
                                                    class="form-control select2" >
                                                    <option value="0" disabled selected>Pilih</option>
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
                                                <label for="">Qty</label>
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="number" id="qty" name="qty" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-3">
                                                <label for="">Price</label>
                                            </div>
                                            <div class="col-sm-5">
                                                <input type="number" id="price" name="price" class="form-control">
                                            </div>
                                        </div>

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-success" onclick="addItem()"> <i class="fa fa-save"></i> Save changes</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="itemEdit" tabindex="-1" aria-labelledby="itemEditLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title" id="itemEditLabel">Edit Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-23">
                                <form action="#" id="formedit">
                                    @csrf
                                    <input type="hidden" name="purchaseDetailId" id="purchaseDetailId_e">

                                    <div class="form-group row">
                                        <div class="col-sm-3">
                                            <label for="">Product</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <select name="productId" id="productId_e"
                                                class="form-control select2" >
                                                <option value="0" disabled selected>Pilih</option>
                                                @forelse ($product as $key=>$item)
                                                    <option value="{{$key}}">{{$item}}</option>
                                                @empty
                                                    <option value="0" disabled>Data Not Found</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-3">
                                            <label for="">Unit</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <select name="unitId" id="unitId_e"
                                                class="form-control select2" >
                                                <option value="0" disabled selected>Pilih</option>
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
                                            <label for="">Qty</label>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="number" id="qty_e" name="qty" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-3">
                                            <label for="">Price</label>
                                        </div>
                                        <div class="col-sm-5">
                                            <input type="number" id="price_e" name="price" class="form-control">
                                        </div>
                                    </div>


                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" onclick="editItem()"> <i class="fa fa-save"></i> Save changes</button>
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
   let purchaseId="{{$purchaseId}}";
    $(document).ready(function () {

        table = $('#tableset').DataTable({

            ajax: {
                url: `/purchase/detail/listDataPurchase/${purchaseId}`,
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
                { data:'product.productName', className: 'text-left'},
                { data:'unit.unitName', className: 'text-center'},
                { data:'qty', className: 'text-right'},
                { data:null, className: 'text-right', render: function (data) {

                        let price = 'Rp.'+data.prices;

                        return price;
                    }
                },
                { data:null, className: 'text-center', render: function (data) {

                        let tampilBtn = '';

                        const params = JSON.stringify(data);
                        tampilBtn += `
                            <button type="button" onclick='showDataEdit(${params})' value=""
                                class="btn btn-sm btn-warning" > <i class="fa fa-edit"></i> Edit</button>
                            <button type="button" onclick="deleteItem(${data.purchaseDetailId})" value="" class="btn btn-sm btn-danger" > <i class="fa fa-trash"></i> Delete</button>
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
        $('#purchaseDetailId_e').val(data.purchaseDetailId);
        $('#price_e').val(data.prices);
        $('#qty_e').val(data.qty);
        $('#productId_e').val(data.productId).select2().trigger('select');
        $('#unitId_e').val(data.unitId).select2().trigger('select');
        $('#itemEdit').modal('show');
    }

    function addItem()
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
                        url: "{{url('/purchase/detail/addDataPurchase')}}",
                        data: formdata+'&purchaseId='+purchaseId,
                        dataType: "json",
                        success: function (response) {

                            if(response.status==200){
                                Swal.fire(
                                    'Saved!',
                                    response.message,
                                    'success'
                                )
                                formreset()
                                $('#itemAdd').modal('hide');
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

    function editItem()
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
                        url: "{{url('/purchase/detail/updateDataPurchase')}}",
                        data: formdata+'&purchaseId='+purchaseId,
                        dataType: "json",
                        success: function (response) {

                            if(response.status==200){
                                Swal.fire(
                                    'Saved!',
                                    response.message,
                                    'success'
                                )

                                $('#itemEdit').modal('hide');
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

    function deleteItem(purchaseDetailId)
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
                        url: "{{url('/purchase/detail/deleteDataPurchase')}}",
                        data: {purchaseDetailId},
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

