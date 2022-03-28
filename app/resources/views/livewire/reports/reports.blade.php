<div class="row sales layout-top-spacing">
    <div class="col-12">
        <div class="widget">
            <div class="widget-heading">
                <h4 class="card-title">
                    <span class="font-weight-bold">
                        {{ $componentName }}
                    </span>
                </h4>

                <div class="widget-content">
                    <div class="row">
                        <div class="col-12 col-md-3">
                            @include('livewire.reports.partials.form')
                        </div>
                        <div class="col-12 col-md-9">
                            @include('livewire.reports.partials.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('livewire.reports.partials.details')
</div>