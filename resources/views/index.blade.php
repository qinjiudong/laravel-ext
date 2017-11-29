@extends('base')
@section('content')
    Ext.onReady(function () {
        var token = "<?php echo csrf_token(); ?>";
        var app = Ext.create("bill.app");
        app.addComp(Ext.create("bill.indexs", {token: token}));
    });
@endsection