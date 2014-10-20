@extends('core::layouts.master')

@section('content-header')
<h1>
    {{ trans('setting::settings.title.module name settings', ['module' => ucfirst($module)]) }}
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
    <li><a href="{{ URL::route('dashboard.setting.index') }}"><i class="fa fa-cog"></i> {{ trans('setting::settings.breadcrumb.settings') }}</a></li>
    <li class="active"><i class="fa fa-cog"></i> {{ trans('setting::settings.breadcrumb.module settings', ['module' => ucfirst($module)]) }}</li>
</ol>
@stop

@section('content')
@include('flash::message')
{!! Form::open(['route' => ['dashboard.module.settings.post'], 'method' => 'post']) !!}
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="{{ App::getLocale() == 'en' ? 'active' : '' }}"><a href="#tab_1-1" data-toggle="tab">{{ trans('core::core.tab.english') }}</a></li>
                        <li class="{{ App::getLocale() == 'fr' ? 'active' : '' }}"><a href="#tab_2-2" data-toggle="tab">{{ trans('core::core.tab.french') }}</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane {{ App::getLocale() == 'en' ? 'active' : '' }}" id="tab_1-1">
                            <?php foreach($moduleSettings as $settingName => $moduleInfo): ?>
                                @include("setting::admin.partials.module-{$moduleInfo['type']}-field", [
                                    'lang' => 'en',
                                    'moduleSettings' => $moduleSettings,
                                    'settings' => $settings,
                                    'module' => $module,
                                    'setting' => $settingName,
                                    'moduleInfo' => $moduleInfo,
                                ])
                            <?php endforeach; ?>
                        </div>
                        <div class="tab-pane {{ App::getLocale() == 'fr' ? 'active' : '' }}" id="tab_2-2">
                            <?php foreach($moduleSettings as $settingName => $moduleInfo): ?>
                                @include("setting::admin.partials.module-{$moduleInfo['type']}-field", [
                                    'lang' => 'fr',
                                    'moduleSettings' => $moduleSettings,
                                    'settings' => $settings,
                                    'module' => $module,
                                    'setting' => $settingName,
                                    'moduleInfo' => $moduleInfo,
                                ])
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.create') }}</button>
                <a class="btn btn-danger pull-right btn-flat" href="{{ URL::route('dashboard.setting.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
@stop
