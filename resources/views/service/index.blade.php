@extends('layouts.base')
@section('body')
<style>
    * {
        margin-top: 10px;
    }

    .left-col {
        float: left;
        width: 25%;
    }

    .center-col {
        float: left;
        width: 50%;
    }

    .right-col {
        float: left;
        width: 25%;
    }
</style>

<div class="container">
    <table id="stable" class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Service ID</th>
                <th>Service Type</th>
                <th>Date of Servicere</th>
                <th>Price</th>
                <th>Operator ID</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="sbody">
        </tbody>
    </table>
</div>
</div>

<div class="modal fade" id="serviceModal" role="dialog" style="display:none">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create new service</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div style="padding: 0 2rem;">
                <form id="oform" action="#" method="#" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="service_id" name="service_id">
                    </div>
                    <div class="form-group">
                        <label for="service_type" class="control-label">Service Type</label>
                        <input type="text" class="form-control" id="service_type" name="service_type">
                    </div>
                    <div class="form-group">
                        <label for="date_of_service" class="control-label">Date of Service</label>
                        <input type="date" class="form-control" id="date_of_service" name="date_of_service">
                    </div>
                    <div class="form-group">
                        <label for="price" class="control-label">price</label>
                        <input type="text" class="form-control" id="price" name="price">
                    </div>
                    <div class="form-group">
                        <label for="operator_id" class="control-label">Operator ID</label>
                        {{-- {!! Form::select('operator_id', App\Models\operator::pluck('name', 'operator_id'), null, [
                        'class' => 'form-control',
                        ]) !!} --}}
                    </div>
                    <div class="form-group">
                        <label for="uploads" class="control-label">service Image</label>
                        <input type="file" class="form-control" id="uploads" name="uploads">
                    </div>
                </form>
            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                <button id="serviceSubmit" type="submit" class="btn btn-primary">Save</button>
                <button id="serviceUpdate" type="submit" class="btn btn-info">Update</button>
            </div>
        </div>
    </div>
</div>
@endsection