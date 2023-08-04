@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h3 class="text-black-50">Product Management</h3>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#productAdd">
          <i class="fa fa-plus"></i>  Add
        </button>

        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table id="tableProduct" class="table table-hover table-bordered" width="100%" style="font-size: 13px">
                        <thead>
                            <tr class="text-center bg-primary">
                                <th class="text-center">No</th>
                                <th class="text-center">Nama Product</th>
                                <th class="text-center">Dimensi</th>
                                <th class="text-center">Categori</th>
                                <th class="text-center">Satuan</th>
                                <th class="text-center">Qty</th>
                                <th class="text-center">Harga</th>
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
        <div class="modal fade" id="productAdd" tabindex="-1" aria-labelledby="productAddLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title" id="productAddLabel">Add Product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-23">
                                    <form action="#" id="formadd">
                                        @csrf
                                        <div class="form-group row">
                                            <div class="col-sm-3">
                                                <label for="">Name Product</label>
                                            </div>
                                            <div class="col-sm-9">
                                               <input type="text" id="productName" name="productName" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-3">
                                                <label for="">Dimension</label>
                                            </div>
                                            <div class="col-sm-5">
                                                <input type="text" id="dimension" name="dimension" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-3">
                                                <label for="">Qty</label>
                                            </div>
                                            <div class="col-sm-5">
                                                <input type="number" id="qty" name="qty" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-3">
                                                <label for="">Categori</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <select name="productCategoriId" id="productCategoriId"
                                                    class="form-control select2" >
                                                    <option value="0" disabled selected>Pilih</option>
                                                    @forelse ($categori as $key=>$item)
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
                            <button type="button" class="btn btn-success" onclick="addProduct()"> <i class="fa fa-save"></i> Save changes</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="productEdit" tabindex="-1" aria-labelledby="productAddLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title" id="productAddLabel">Edit Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-23">
                                <form action="#" id="formedit">
                                    @csrf
                                    <input type="hidden" name="productId" id="productId_e">
                                    <input type="hidden" name="productPriceId" id="productPriceId_e">
                                    <div class="form-group row">
                                        <div class="col-sm-3">
                                            <label for="">Name Product</label>
                                        </div>
                                        <div class="col-sm-9">
                                           <input type="text" id="productName_e" name="productName" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-3">
                                            <label for="">Dimension</label>
                                        </div>
                                        <div class="col-sm-5">
                                            <input type="text" id="dimension_e" name="dimension" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-3">
                                            <label for="">Categori</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <select name="productCategoriId" id="productCategoriId_e"
                                                class="form-control select2" >
                                                <option value="0" disabled>Pilih</option>
                                                @forelse ($categori as $key=>$item)
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
                                            <label for="">Qty</label>
                                        </div>
                                        <div class="col-sm-5">
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
                        <button type="button" class="btn btn-success" onclick="editProduct()"> <i class="fa fa-save"></i> Save changes</button>
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

        table = $('#tableProduct').DataTable({

            ajax: {
                url: `/listDataProduct`,
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
                { data:'productName', className: 'text-left'},
                { data:'dimensions', className: 'text-left'},
                { data:'categori.categori', className: 'text-center'},
                { data:'unit.unitName', className: 'text-center'},
                { data:'qty', className: 'text-center'},
                { data:null, className: 'text-right', render: function (data) {

                        let price = 'Rp.'+data.product_price.price;

                        return price;
                    }
                },
                { data:null, className: 'text-center', render: function (data) {

                        let tampilBtn = '';

                        const params = JSON.stringify(data);
                        tampilBtn += `
                            <button type="button" onclick='showDataEdit(${params})' value=""
                                class="btn btn-sm btn-warning" > <i class="fa fa-edit"></i> Edit</button>
                            <button type="button" onclick="deleteProduct(${data.productId})" value="" class="btn btn-sm btn-danger" > <i class="fa fa-trash"></i> Delete</button>
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
        $('#productId_e').val(data.productId);
        $('#productPriceId_e').val(data.product_price.productPriceId);
        $('#price_e').val(data.product_price.price);
        $('#productName_e').val(data.productName);
        $('#dimension_e').val(data.dimensions);
        $('#qty_e').val(data.qty);
        $('#productCategoriId_e').val(data.productCategoriId).select2().trigger('select');
        $('#unitId_e').val(data.unitId).select2().trigger('select');
        $('#productEdit').modal('show');
    }

    function addProduct()
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
                        url: "{{url('/addDataProduct')}}",
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
                                $('#productAdd').modal('hide');
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

    function editProduct()
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
                        url: "{{url('/updateDataProduct')}}",
                        data: formdata,
                        dataType: "json",
                        success: function (response) {

                            if(response.status==200){
                                Swal.fire(
                                    'Saved!',
                                    response.message,
                                    'success'
                                )

                                $('#productEdit').modal('hide');
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

    function deleteProduct(productId)
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
                        url: "{{url('/deleteDataProduct')}}",
                        data: {productId},
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

