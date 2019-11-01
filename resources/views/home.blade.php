@extends('layouts.app')

@section('content')
<div class="container">
    <div class="justify-content-center">

        <div class="row">
            <div class="col-lg">
                <div class="card">
                    <div class="card-header">MineSweeper Game</div>
                    <div class="card-body">
                        Made with Php and Vue Js
                    </div>
                </div>
            </div>
        </div>

        <div class="row ">
            <div class="col-md-8">
                <minesweeper></minesweeper>
            </div>
        </div>

    </div>
</div>
@endsection
