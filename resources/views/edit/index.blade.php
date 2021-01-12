@extends('DashboardModule::dashboard.index')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @include('DashboardModule::partials.alerts')
                        <h4 class="card-title">Dodawanie nowego menu</h4>
                        <form class="form" method="POST" action="{{route('MenuModule::menu.update', ['menu' => $menu])}}">
                            @csrf
                            @method('PUT')
                            <div class="form-group @error('name') has-danger @enderror">
                                <label for="">Nazwa</label>
                                <input type="text" class="form-control" name="name" placeholder="Wpisz nazwe" value="{{$menu->name}}">
                                <small></small>
                                @error('name')
                                <small class="error mt-1 text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="">Struktura  <button type="button" class="ml-2 btn btn-sm btn-primary add-menu-simple-structure"><i class="mdi mdi-plus"></i>Dodaj prosty typ</button> <button type="button" class="ml-2 btn btn-sm bg-purple add-menu-structure text-white"><i class="mdi mdi-plus"></i>Dodaj strukture z modułu</button></label>
                                <input type="hidden" name="structure">
                                <div class="structure">
                                </div>

                                @error('structure')
                                <small class="error mt-1 text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>
                            <button type="submit" class="float-right mt-2 btn btn-primary mr-2 save-button">Zapisz</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @javascript('modulesMenusItems', get_module('MenuModule')->getModulesMenus())
    @javascript('structure', $menu->structure)
@endsection

@section('stylesheets')
    <link rel="stylesheet" href="{{mix('vendor/css/MenuModule.css')}}">
@endsection

@section('javascripts')
    <script src="{{mix('vendor/js/MenuModule.js')}}"></script>
@endsection
