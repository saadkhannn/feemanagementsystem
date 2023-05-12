<div class="card" style="margin-bottom: 25px;">
    <div class="card-header bg-info text-white {{ !$report ? 'collapsed' : '' }}" data-toggle="collapse" data-target="#filter" style="cursor: pointer;" onclick="$('.filter-icon').toggleClass('fa-rotate-180')">
        <h6 class="mb-0">
        	<strong>Filter</strong>
        	<i class="fa fa-caret-down filter-icon" style="float: right"></i>
        </h6>
    </div>
    <div class="card-body collapse {{ !$report ? '' : 'show' }}" id="filter">
        <form action="{{ url($url) }}" method="get" accept-charset="utf-8" id="filter-form">
        <input type="hidden" name="type" id="type" value="search">
            <div class="row">
            	<div class="col-md-1">
                    <label for="from"><strong>From</strong></label>
                    <input type="date" name="from" id="from" value="{{ strtotime(request()->get('from')) > 0 ? request()->get('from') : date('Y-m-01') }}" class="form-control" placeholder="From">
                </div>
                <div class="col-md-1">
                    <label for="to"><strong>To</strong></label>
                    <input type="date" name="to" id="to" value="{{ strtotime(request()->get('to')) > 0 ? request()->get('to') : date('Y-m-d') }}" class="form-control" placeholder="To">
                </div>
        		<div class="col-md-8">
                    <div class="row">
                        @if(!$report)
                        <div class="col-md-2">
                            <label><strong>&nbsp;</strong></label>
                            <button type="button" class="btn btn-md btn-block btn-primary" onclick="$('#type').val('search');$('#filter-form').removeAttr('target');$('#filter-form').submit()"><i class="fa fa-search"></i>&nbsp;&nbsp;Search</button>
                        </div>
                        @endif

                        @if($report)
                            @if(auth()->user()->allPermissions([(isset($permission) ? $permission : '').'-print']))
                                <div class="col-md-2 pl-0">
                                    <label><strong>&nbsp;</strong></label>
                                    <button type="button" class="btn btn-md btn-block btn-success" onclick="$('#type').val('print');$('#filter-form').attr('target', '_blank');$('#filter-form').submit()"><i class="fas fa-print"></i>&nbsp;&nbsp;Print</button>
                                </div>
                            @endif

                            @if(auth()->user()->allPermissions([(isset($permission) ? $permission : '').'-pdf']))
                                <div class="col-md-2 pl-0">
                                    <label><strong>&nbsp;</strong></label>
                                    <button type="button" class="btn btn-md btn-block btn-info" onclick="$('#type').val('pdf');$('#filter-form').removeAttr('target');$('#filter-form').submit()"><i class="far fa-file-pdf"></i>&nbsp;&nbsp;PDF</button>
                                </div>
                            @endif

                            @if(auth()->user()->allPermissions([(isset($permission) ? $permission : '').'-excel']))
                                <div class="col-md-2 pl-0">
                                    <label><strong>&nbsp;</strong></label>
                                    <button type="button" class="btn btn-md btn-block btn-primary" onclick="$('#type').val('excel');$('#filter-form').removeAttr('target');$('#filter-form').submit()"><i class="fas fa-file-excel"></i>&nbsp;&nbsp;Excel</button>
                                </div>
                            @endif
                        @endif
                        
                        <div class="col-md-2">
                            <label><strong>&nbsp;</strong></label>
                            <a class="btn btn-md btn-block btn-danger" href="{{ url($url) }}"><i class="fas fa-sync-alt"></i>&nbsp;&nbsp;Reset</a>
                        </div>
                    </div>
                </div>    	
            </div>   
        </form>
    </div>
</div>