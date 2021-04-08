@extends('voyager::master')

@section('page_title', __('voyager::generic.view').' '.$dataType->getTranslatedAttribute('display_name_singular'))

@section('page_header')
<h1 class="page-title">
    <i class="{{ $dataType->icon }}"></i> {{ __('voyager::generic.viewing') }}
    {{ ucfirst($dataType->getTranslatedAttribute('display_name_singular')) }} &nbsp;

    @can('edit', $dataTypeContent)
    <a href="{{ route('voyager.'.$dataType->slug.'.edit', $dataTypeContent->getKey()) }}" class="btn btn-info">
        <span class="glyphicon glyphicon-pencil"></span>&nbsp;
        {{ __('voyager::generic.edit') }}
    </a>
    @endcan
    @can('delete', $dataTypeContent)
    @if($isSoftDeleted)
    <a href="{{ route('voyager.'.$dataType->slug.'.restore', $dataTypeContent->getKey()) }}"
        title="{{ __('voyager::generic.restore') }}" class="btn btn-default restore"
        data-id="{{ $dataTypeContent->getKey() }}" id="restore-{{ $dataTypeContent->getKey() }}">
        <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">{{ __('voyager::generic.restore') }}</span>
    </a>
    @else
    <a href="javascript:;" title="{{ __('voyager::generic.delete') }}" class="btn btn-danger delete"
        data-id="{{ $dataTypeContent->getKey() }}" id="delete-{{ $dataTypeContent->getKey() }}">
        <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">{{ __('voyager::generic.delete') }}</span>
    </a>
    @endif
    @endcan
    @can('browse', $dataTypeContent)
    <a href="{{ route('voyager.'.$dataType->slug.'.index') }}" class="btn btn-warning">
        <span class="glyphicon glyphicon-list"></span>&nbsp;
        {{ __('voyager::generic.return_to_list') }}
    </a>
    @endcan
</h1>
@include('voyager::multilingual.language-selector')
@stop

@section('content')
<div class="page-content read container-fluid">
    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-bordered row" style="padding-bottom:5px;">

                {{-- Start Custom Order Products Section --}}

                <div class="panel-heading" style="border-bottom:0;">
                    <h3 class="panel-title">Products</h3>
                </div>
                <div class="panel-body" style="padding-top:0;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>@lang('backend.id')</th>
                                <th>@lang('backend.name')</th>
                                <th>@lang('backend.price')</th>
                                <th>@lang('backend.quantity')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataTypeContent->products as $product)

                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>@money( $product->price )</td>
                                <td>{{ $product->pivot->quantity }}</td>
                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- End Custom Order Products Section --}}

                <!-- Loop Start -->
                @foreach($dataType->readRows as $row)

                {{-- Modify The Text Of Some fields --}}
                @php
                    if( $row->field === 'error' ) $dataTypeContent->{$row->field} = $dataTypeContent->{$row->field} !== null ? $dataTypeContent->{$row->field} : __('backend.no_error');
                    if( $row->field === 'shipped' ) $dataTypeContent->{$row->field} ? __('backend.yes') : __('backend.no');
                    if( $row->field === 'is_paid' ) $dataTypeContent->{$row->field} ? __('backend.yes') : __('backend.no');
                    if( $row->field === 'discount_code' ) $dataTypeContent->{$row->field} = $dataTypeContent->{$row->field} !== null ? $dataTypeContent->{$row->field} : __('backend.no_discount');
                    if( $row->field === 'name_on_card' ) $dataTypeContent->{$row->field} = $dataTypeContent->{$row->field} !== null ? $dataTypeContent->{$row->field} : __('backend.no_card_is_used');
                @endphp

                @php
                if ($dataTypeContent->{$row->field.'_read'}) {
                $dataTypeContent->{$row->field} = $dataTypeContent->{$row->field.'_read'};
                }
                @endphp
                <div class="col-xs-6 col-sm-4 col-md-3">
                    <div class="panel-heading" style="border-bottom:0;">
                        <h3 class="panel-title">{{ $row->getTranslatedAttribute('display_name') }}</h3>
                    </div>

                    <div class="panel-body" style="padding-top:0;">
                        @if (isset($row->details->view))
                        @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' =>
                        $dataTypeContent, 'content' => $dataTypeContent->{$row->field}, 'action' => 'read', 'view' =>
                        'read', 'options' => $row->details])
                        @elseif($row->type == "image")
                        <img class="img-responsive"
                            src="{{ filter_var($dataTypeContent->{$row->field}, FILTER_VALIDATE_URL) ? $dataTypeContent->{$row->field} : Voyager::image($dataTypeContent->{$row->field}) }}">
                        @elseif($row->type == 'multiple_images')
                        @if(json_decode($dataTypeContent->{$row->field}))
                        @foreach(json_decode($dataTypeContent->{$row->field}) as $file)
                        <img class="img-responsive"
                            src="{{ filter_var($file, FILTER_VALIDATE_URL) ? $file : Voyager::image($file) }}">
                        @endforeach
                        @else
                        <img class="img-responsive"
                            src="{{ filter_var($dataTypeContent->{$row->field}, FILTER_VALIDATE_URL) ? $dataTypeContent->{$row->field} : Voyager::image($dataTypeContent->{$row->field}) }}">
                        @endif
                        @elseif($row->type == 'relationship')
                        @include('voyager::formfields.relationship', ['view' => 'read', 'options' => $row->details])
                        @elseif($row->type == 'select_dropdown' && property_exists($row->details, 'options') &&
                        !empty($row->details->options->{$dataTypeContent->{$row->field}})
                        )
                        <?php echo $row->details->options->{$dataTypeContent->{$row->field}};?>
                        @elseif($row->type == 'select_multiple')
                        @if(property_exists($row->details, 'relationship'))

                        @foreach(json_decode($dataTypeContent->{$row->field}) as $item)
                        {{ $item->{$row->field}  }}
                        @endforeach

                        @elseif(property_exists($row->details, 'options'))
                        @if (!empty(json_decode($dataTypeContent->{$row->field})))
                        @foreach(json_decode($dataTypeContent->{$row->field}) as $item)
                        @if (@$row->details->options->{$item})
                        {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                        @endif
                        @endforeach
                        @else
                        {{ __('voyager::generic.none') }}
                        @endif
                        @endif
                        @elseif($row->type == 'date' || $row->type == 'timestamp')
                        @if ( property_exists($row->details, 'format') && !is_null($dataTypeContent->{$row->field}) )
                        {{ \Carbon\Carbon::parse($dataTypeContent->{$row->field})->formatLocalized($row->details->format) }}
                        @else
                        {{ $dataTypeContent->{$row->field} }}
                        @endif
                        @elseif($row->type == 'checkbox')
                        @if(property_exists($row->details, 'on') && property_exists($row->details, 'off'))
                        @if($dataTypeContent->{$row->field})
                        <span class="label label-info">{{ $row->details->on }}</span>
                        @else
                        <span class="label label-primary">{{ $row->details->off }}</span>
                        @endif
                        @else
                        {{ $dataTypeContent->{$row->field} }}
                        @endif
                        @elseif($row->type == 'color')
                        <span class="badge badge-lg"
                            style="background-color: {{ $dataTypeContent->{$row->field} }}">{{ $dataTypeContent->{$row->field} }}</span>
                        @elseif($row->type == 'coordinates')
                        @include('voyager::partials.coordinates')
                        @elseif($row->type == 'rich_text_box')
                        @include('voyager::multilingual.input-hidden-bread-read')
                        {!! $dataTypeContent->{$row->field} !!}
                        @elseif($row->type == 'file')
                        @if(json_decode($dataTypeContent->{$row->field}))
                        @foreach(json_decode($dataTypeContent->{$row->field}) as $file)
                        <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($file->download_link) ?: '' }}">
                            {{ $file->original_name ?: '' }}
                        </a>
                        <br />
                        @endforeach
                        @else
                        <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($row->field) ?: '' }}">
                            {{ __('voyager::generic.download') }}
                        </a>
                        @endif
                        @else
                        @include('voyager::multilingual.input-hidden-bread-read')
                        @if( in_array( $row->field, ['discount', 'subtotal', 'tax', 'total']) )
                            {{-- Number Formatting And Add The Coin Sign --}}
                            <p>@money( $dataTypeContent->{$row->field} )</p>
                        @else
                            <p>{{ $dataTypeContent->{$row->field} }}</p>
                        @endif

                        @endif
                    </div><!-- ./panel-body -->
                </div><!-- ./col -->
                @if(!$loop->last)
                <hr style="margin:0;">
                @endif
                @endforeach

            </div>
        </div>
    </div>
</div>

{{-- Single delete modal --}}
<div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="voyager-trash"></i> {{ __('voyager::generic.delete_question') }}
                    {{ strtolower($dataType->getTranslatedAttribute('display_name_singular')) }}?</h4>
            </div>
            <div class="modal-footer">
                <form action="{{ route('voyager.'.$dataType->slug.'.index') }}" id="delete_form" method="POST">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <input type="submit" class="btn btn-danger pull-right delete-confirm"
                        value="{{ __('voyager::generic.delete_confirm') }} {{ strtolower($dataType->getTranslatedAttribute('display_name_singular')) }}">
                </form>
                <button type="button" class="btn btn-default pull-right"
                    data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@stop

@section('javascript')
@if ($isModelTranslatable)
<script>
    $(document).ready(function () {
                    $('.side-body').multilingual();
                });
</script>
@endif
<script>
    var deleteFormAction;
            $('.delete').on('click', function (e) {
                var form = $('#delete_form')[0];

                if (!deleteFormAction) {
                    // Save form action initial value
                    deleteFormAction = form.action;
                }

                form.action = deleteFormAction.match(/\/[0-9]+$/)
                    ? deleteFormAction.replace(/([0-9]+$)/, $(this).data('id'))
                    : deleteFormAction + '/' + $(this).data('id');

                $('#delete_modal').modal('show');
            });

</script>
@stop
