@extends('layouts.layout')

@section('title','Tax Rules')
@section('content')
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="kt-portlet kt-portlet--last kt-portlet--head-lg kt-portlet--responsive-mobile">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">Active Tax rule 
                        <small class="small-txt"></small>
                    </h3>
                </div>
                <div class="d-flex flex-row align-items-center">
                    <button class="pull-right btn-add-tax-rule btn btn-info">Add</button> 
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="tax-list">
                    <ul class="tax-rules d-flex flex-column" data-deactivate-url="">
                        @foreach($income_tax->slab as $slab)
                            <li class="hmb-2" id="tax-rule-{{$slab->id}}" data-id="{{$slab->id}}">
                                <span><i class="fa fa-sort hmr-2"></i>{{$slab->amount}} ({{$slab->percent}}%)</span>
                                <span class="pull-right"><button type="button" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-sm btn-deactivate"><i class="fa fa-times-circle"></i></button></span>
                            </li>
                        @endforeach                    
                    </ul>
                </div>
                
            </div>  
        </div>
    </div>
</div>

@endsection
@section('modals')
    <div class="modal fade modal-aside add-tax-modal" tabindex="-1" role="dialog" aria-labelledby="tipModal" aria-hidden="true" >
        <div class="modal-dialog width-80" role="document">
            <div class="modal-content mcontent">
                <div class="modal-header  mheader bg-grey">
                    <h5 class="modal-title" id="exampleModalLabel"> <span class="add-modal-title-name">Add new slab</span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form class='add-tax-slab-form' method='POST' data-action="{{route('income-tax.tax-slab.create')}}">
                    <input type="hidden" class="important" name="income_tax_id" value="{{$income_tax->id}}">
                    <div class="modal-body">
                        <div class="add-modal-info">
                            <div class="form-group row">
                                <label class="col-3 col-form-label">Amount</label>
                                <div class="col-9">
                                    <input class="form-control" name="amount" type="number" placeholder="Amount" required autofocus/>
                                    <span class="invalid-feedback" role="alert">
                                        <strong class="error-name"></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3 col-form-label">Percent </label>
                                <div class="col-9">
                                    <input class="form-control" name="percent" type="number" min=1 placeholder="Percent" required/>
                                    <span class="invalid-feedback" role="alert">
                                        <strong class="error-percent"></strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-brand btn btn-primary">
                            <i class="la la-check"></i>
                            <span class="kt-hidden-mobile">Save</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('css')
    <style>
        .tax-list ul{
            list-style: none;
            padding-left: 0;
        }
        .tax-list ul li{
            background-color:#f4f4f8;
            padding: 20px 25px;
        }
        .tax-list ul li span:first-child{
            text-transform: uppercase;
            padding-bottom: 10px;
            color: #906e57;
            font-weight: 500;
        }
        .tax-list ul li span:last-child button{
            color: #fff;
            background-color: #906e57;
            border-color: #906e57;
        }
        .tax-list .btn-sm i{
            padding-right:0!important;
        }
        .hmr-2{
            margin-right: 1rem;
        }
        .hmb-2{
            margin-bottom: 1rem;
        }
        .tax-list ul li .btn{
            background-color:red!important;
            border-color:red!important;
        }
        .tax-list ul li .btn-activate{
            background-color:green!important;
            border-color:green!important;
        }
    </style>
@endsection

@section('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
    <script>
        var update_order_url="{{route('income-tax.tax-slab.update.order')}}"
        initSortable()
        $(document).on('click','.btn-add-tax-rule',function(){
            $('.add-tax-modal').modal('show')            
        })
        $(document).on('submit','.add-tax-slab-form',function(e){
            e.preventDefault();
            var data= $(this).serialize()
            var action= $(this).data('action')

            $.ajax({
                method: "POST",
                url: action,
                data: data
            })
            .done(function(data) {
                var res=JSON.parse(data)
                if(res.status){
                    var content='<li class="hmb-2" id="tax-rule-'+res.tax_slab_id+'" data-id="'+res.tax_slab_id+'">'+
                        '<span><i class="fa fa-sort hmr-2"></i>'+res.tax_slab.amount+'  ('+res.tax_slab.percent+'%)</span>'+
                        '<span class="pull-right"><button type="button" style="--main_header_color : {{ $settings->main_header_color }};" class="btn btn-primary btn-sm btn-deactivate"><i class="far fa-times-circle"></i></button></span>'+
                    '</li>'
                    $('.tax-rules').append(content)
                    .sortable("refresh");
                    $('.modal').modal('hide')
                }
                console.log('Tax rule oder updated')
            })
        })
        $(document).on('click','.btn-deactivate',function(e){
            var this_ul=$(this).closest('li')
            var id=this_ul.data('id')
            var action=this_ul.closest('ul').data('deactivate-url')
            
            Swal.fire({
                        title: 'Deactivate Tax Rule?',
                        text: 'Do you want to deactivate this tax rule?',
                        type: 'info',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes!',        
                    }).then(function(result) {
                        if (result.value) {                    
                            $.ajax({
                                method: "POST",
                                url: action,
                                data: {
                                    id:id
                                }
                            })
                            .done(function(data) {
                                swal.close();
                                var res=JSON.parse(data)
                                if(res.status){
                                    this_ul.remove()
                                    var inactive_ul_content=''+
                                    '<li class="hmb-2" id="inactive-tax-rule-'+res.tax_rule_id+'" data-id="'+res.tax_rule_id+'">'+
                                        '<span>'+res.tax_rule.name+' ('+res.tax_rule.percent+'%)</span>'+
                                        '<span class="pull-right"><button type="button" class="btn btn-success btn-sm btn-activate"><i class="far fa-check-circle"></i></button></span>'+
                                    '</li>'
                                    console.log(inactive_ul_content)
                                    $('.inactive-tax-list').append(inactive_ul_content)
                                }else{
                                    Swal.fire({
                                        title: 'Oops!',
                                        text: res.message,
                                        type: 'info',
                                        showCancelButton: true,
                                        showConfirmButton: false,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        cancelButtonText: 'Ok!',        
                                    })
                                }
                                
                                
                            })
                        }else{
                        }
                    })
        })
        $(document).on('click','.btn-activate',function(e){
            var this_ul=$(this).closest('li')
            var id=this_ul.data('id')
            var action=this_ul.closest('ul').data('activate-url')
            
            Swal.fire({
                        title: 'Activate Tax Rule?',
                        text: 'Do you want to activate this tax rule?',
                        type: 'info',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes!',        
                    }).then(function(result) {
                        if (result.value) {                    
                            $.ajax({
                                method: "POST",
                                url: action,
                                data: {
                                    id:id
                                }
                            })
                            .done(function(data) {
                                swal.close();
                                var res=JSON.parse(data)
                                if(res.status){
                                    this_ul.remove()
                                    var inactive_ul_content=''+
                                    '<li class="hmb-2" id="tax-rule-'+res.tax_rule_id+'" data-id="'+res.tax_rule_id+'">'+
                                        '<span><i class="fa fa-sort hmr-2"></i>'+res.tax_rule.name+' ('+res.tax_rule.percent+'%)</span>'+
                                        '<span class="pull-right"><button type="button" class="btn btn-success btn-deactivate btn-sm"><i class="far fa-times-circle"></i></button></span>'+
                                    '</li>'
                                    
                                    $('.tax-rules').append(inactive_ul_content)
                                    .sortable("refresh");
                                }else{
                                    Swal.fire({
                                        title: 'Oops!',
                                        text: res.message,
                                        type: 'info',
                                        showCancelButton: true,
                                        showConfirmButton: false,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        cancelButtonText: 'Ok!',        
                                    })
                                }
                                
                                
                            })
                        }else{
                        }
                    })
        })
        function initSortable(){
            $('.tax-rules').sortable({
                axis: 'y',
                update: function(event, ui) {
                    var order = $(this).sortable('toArray');
                    //Update order
                    $.ajax({
                        method: "POST",
                        url: update_order_url,
                        data: {
                            order:order,
                        }
                    })
                    .done(function(res) {
                        console.log('Tax rule oder updated')
                    })
                }
            });
        }

        $('.modal').on('shown.bs.modal', function () { //Done
            $(this).find('[autofocus]').focus();
        });
        $('.modal').on('hidden.bs.modal', function () { //Done
            
            $(this).find('textarea').val('');
            $(this).find('input:not(.important)').val('')
        })
    </script>
@endsection
