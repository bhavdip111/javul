@extends('layout.default')
@section('page-css')
<style>
    hr, p{margin:0 0 10px !important;}
    .files_image:hover{text-decoration: none;}
    .file_documents{display: inline-block;padding: 10px;}
</style>
@endsection
@section('content')

<div class="container">
    <div class="row">
        @include('elements.user-menu',['page'=>'tasks'])
    </div>
    <div class="row form-group">
        <div class="col-sm-12">
            <div class="col-sm-12 grey-bg unit_description">
                <h2 class="unit-heading"><span class="glyphicon glyphicon-edit"></span> &nbsp; <strong>{{$taskObj->name}}</strong></h2>
                <div class="form-group">
                    <a class="btn orange-bg" id="edit_task" href="{!! url('tasks/'.$taskIDHashID->encode($taskObj->id).'/edit')!!}"><span
                            class="glyphicon glyphicon-pencil"></span> &nbsp;
                        {!! trans('messages.edit_task') !!}</a>
                </div>
                <div class="panel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <strong>{!! trans('messages.unit_information') !!}<span class="caret"></span> </strong>
                            </div>
                            <div class="col-xs-5">{!! trans('messages.unit_name') !!}</div>
                            <div class="col-xs-7 text-right">{{$taskObj->unit->name}}</div>
                            <div class="col-xs-5">{!! trans('messages.type') !!}</div>
                            <div class="col-xs-7 text-right">{{$taskObj->unit->category_name}}</div>
                            <div class="col-xs-5">{!! trans('messages.funds') !!}</div>
                            <div class="col-xs-7 text-right">{!! trans('messages.available') !!}: xxxx$</div>
                            <div class="col-xs-5">{!! trans('messages.awarded') !!}</div>
                            <div class="col-xs-7 text-right">xxx$</div>
                            <div class="col-xs-12 text-right">
                                <button class="btn orange-bg btn-sm" id="add_funds">{!! trans('messages.add_funds') !!}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
                <li class="active"><a href="#task_details" data-toggle="tab">Task Details</a></li>
                <li><a href="#task_actions" data-toggle="tab">Task Actions</a></li>
                <li><a href="#objective_details" data-toggle="tab">Objective Details</a></li>
                <li><a href="#unit_details" data-toggle="tab">Unit Details</a></li>
            </ul>
            <div id="my-tab-content" class="tab-content">
                <div class="list-group tab-pane active" id="task_details">

                    <div class="list-group-item">
                        <h4 class="text-orange">{!! strtoupper(trans('messages.task_status')) !!}</h4>
                        @if(empty($taskObj->assigned_to))
                            <div>Unassigned</div>
                        @elseif($taskObj->status == "completed")
                            <div>Completed</div>
                            <div>Completed On: date 23/05/2016</div>
                        @else
                            <div>assigned to user X</div>
                        @endif
                    </div>
                    <div class="list-group-item">
                        <h4 class="text-orange">{!! strtoupper(trans('messages.task_award')) !!}</h4>
                        <div>xx $</div>
                    </div>
                    <div class="list-group-item">
                        <h4 class="text-orange">{!! strtoupper(trans('messages.task_summary')) !!}</h4>
                        <div>{!! $taskObj->summary !!}</div>
                    </div>
                    <div class="list-group-item">
                        <h4 class="text-orange">{!! strtoupper(trans('messages.long_description')) !!}</h4>
                        <div>{!! $taskObj->description !!}</div>
                    </div>
                    <div class="list-group-item">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="text-orange">Task Documents</h4>
                                @if(!empty($taskObj->task_documents))
                                @foreach($taskObj->task_documents as $document)
                                <?php $extension = pathinfo($document->file_path, PATHINFO_EXTENSION); ?>
                                @if($extension == "pdf") <?php $extension="pdf"; ?>
                                @elseif($extension == "doc" || $extension == "docx") <?php $extension="docx"; ?>
                                @elseif($extension == "jpg" || $extension == "jpeg") <?php $extension="jpeg"; ?>
                                @elseif($extension == "ppt" || $extension == "pptx") <?php $extension="pptx"; ?>
                                @else <?php $extension="file"; ?> @endif
                                <div class="file_documents">
                                <a class="files_image" href="{!! url($document->file_path) !!}" target="_blank">
                                    <img src="{!! url('assets/images/file_types/'.$extension.'.png') !!}" style="height:50px;">
                                    <span style="display:block">
                                        @if(empty($document->file_name))
                                            &nbsp;
                                        @else
                                            {{$document->file_name}}
                                        @endif
                                    </span>
                                </a>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
                <div class="list-group tab-pane" id="task_actions">
                    <div class="list-group-item">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="text-orange">TASK ACTIONS</h4>
                                <div>{!! $taskObj->task_action !!}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="list-group tab-pane" id="objective_details">
                    <div class="list-group-item">
                        <h4 class="text-orange">{!! strtoupper(trans('messages.objective')) !!}</h4>
                        <div>{{$taskObj->objective->name}}</div>
                    </div>
                    <div class="list-group-item">
                        <h4 class="text-orange">OBJECTIVE DESCRIPTION</h4>
                        {!! $taskObj->objective->description !!}
                    </div>
                </div>
                <div class="list-group tab-pane" id="unit_details">
                    <div class="list-group-item">
                        <h4 class="text-orange">UNIT</h4>
                        <div>{{$taskObj->unit->name}}</div>
                    </div>
                    <div class="list-group-item">
                        <h4 class="text-orange">CATEGORY</h4>
                        {!! $taskObj->unit->category_name !!}
                    </div>
                    <div class="list-group-item">
                        <h4 class="text-orange">DESCRIPTION</h4>
                        {!! $taskObj->unit->description !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('elements.footer')
@endsection
@section('page-scripts')
<script type="text/javascript">
    $(function(){
        $('#tabs').tab();
    })
</script>
@endsection