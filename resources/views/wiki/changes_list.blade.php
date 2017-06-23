@extends('layout.default')
@section('page-css')
    <link href="{!! url('assets/css/wiki.css') !!}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<link rel="stylesheet" type="text/css" href="{!! url('assets/css/forum.css') !!}">
<div class="container">
    <div class="row form-group" style="margin-bottom: 15px;">
        @include('elements.user-menu',['page'=>'units'])
    </div>
    <div class="row form-group">
        <div class="col-md-4">
            @include('units.partials.unit_information_left_table')
            <div class="left" style="position: relative;margin-top: 30px;">
                <div class="site_activity_loading loading_dots" style="position: absolute;top:20%;left:43%;z-index: 9999;display: none;">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <div class="site_activity_list">
                    @include('elements.site_activities',['ajax'=>false])
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-grey panel-default">
                
                <div class="panel-heading current_task_heading  current_task_heading_red featured_unit_heading">
                    <div class="featured_unit current_task red">
                        <i class="fa fa-book"></i>
                    </div>
                    <h4>Recent Changes</h4>
                    <div class="button pull-right small-a">
                        <a href="{!! url('wiki/edit') !!}/{!! $unit_id !!}/{!! $slug !!}">+ New Page</a> | 
                        <a href="{!! url('wiki/recent_changes') !!}/{!! $unit_id !!}/{!! $slug !!}">Recent Changes</a> | 
                        <a href="{!! url('wiki/all_pages') !!}/{!! $unit_id !!}/{!! $slug !!}">List All Page</a>
                    </div>
                </div>
                <div class="panel-body list-group">
                    <div class="col-md-12">
                        <div class="table-responsive">
                          <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Time</th>
                                    <th>Byte</th>
                                    <th>Username</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($changes['changes'])){ ?>
                                    <tr>
                                        <td colspan="5" class="text-center"> <h4>No any changes Created yet..  </h4> </td>
                                    </tr>
                                <?php  } ?>
                                <?php foreach ($changes['changes'] as $key => $page) { ?>
                                    <tr>
                                        <td>
                                            <!-- <a href="{!! url('wiki/revision_view') !!}/{!! $unit_id !!}/{!! $page['revision_id'] !!}/{!! $slug !!}">View</a> | --> 
                                            <a href="{!! url('wiki/diff') !!}/{!! $unit_id !!}/{!! $page['revision_id'] !!}/{!! $slug !!}">Diff</a> | 
                                            <a href="{!! url('wiki/history') !!}/{!! $unit_id !!}/{!! $page['wiki_page_id'] !!}/{!! $slug !!}">Hist</a> 
                                        </td>
                                        <td>
                                         <a href="{!! url('wiki').'/'.$unit_id.'/'. $page['wiki_page_id'] .'/'.$slug !!}"><?= $page['wiki_page_title'] ?></a>
                                        </td>
                                        <td><?= $page['time_stamp'] ?></td>
                                        <td><?= $page['change_byte'] ?></td>
                                        <td>
                                        <a href='<?= $page['userlink'] ?>' ><?= $page['user_name'] ?> </a>
                                        (<?= $page['edit_comment'] != '' ? $page['edit_comment'] : '<small> No Comment </small>' ?>)</td>
                                        
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-center" colspan="100%"><?= $changes['links'] ?></td>
                                </tr>
                            </tfoot>
                          </table>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
@include('elements.footer')
@stop
@section('page-scripts') 
@endsection
