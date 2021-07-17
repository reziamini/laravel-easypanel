<div>
    <div class="card">
        <div class="card-header p-0">
            <h3 class="card-title">{{ __('ListTitle', ['name' => __('CRUD')]) }}</h3>

            <ul class="breadcrumb mt-3 py-3 px-4 rounded" style="background-color: #e9ecef!important;">
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')" class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item active">{{ __('CRUD Manager') }}</li>
            </ul>
        </div>


        <div class="mt-4 px-2 rounded">
            <div class="mt-2">
                @livewire('admin::livewire.crud.create')
            </div>
            @if($cruds->count() > 0)
                <div class="mt-4 card-body table-responsive p-0">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <td>{{ __('Model') }}</td>
                            <td>{{ __('Route') }}</td>
                            <td>{{ __('Status') }}</td>
                            <td>{{ __('Built') }}</td>
                            <td>{{ __('Action') }}</td>
                        </tr>

                        @foreach($cruds as $crud)
                            @livewire('admin::livewire.crud.single', ['crud' => $crud], key($crud->id))
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="mt-3 alert alert-warning">
                    {{ __('There is no record for CRUD in database!') }}
                </div>
            @endif

        </div>

    </div>
</div>
