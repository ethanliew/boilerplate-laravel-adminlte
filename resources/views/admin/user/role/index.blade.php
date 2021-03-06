@extends($layout)

@section('title', trans('menu.user_roles'))

@section('breadcrumb')
    @include('shared._breadcrumb', [
        'breadcrumbs' => [
            [
                'name' => trans('menu.application_settings'),
                'class' => '',
            ],
            [
                'name' => trans('menu.users'),
                'class' => '',
            ],
            [
                'name' => trans('menu.user_roles'),
                'class' => 'active',
                'route' => 'admin.user.role.index',
            ]
        ]
    ])
@endsection


@section('content')

    <div class="box border-top-0">

        <div class="box-header">
            @include('shared.buttons._create', ['route' => 'admin.user.role.create'])

            @include('shared._search', [
                'dataSearch' => 'table',
                'target' => '#role-index'
            ])
        </div>

        <div class="box-body p-0" id="role-index">

            @component('shared.components._table')

                @slot('thead')
                    <tr>
                        <th scope="col">
                            @lang('role.field.name')
                            <i class="fa fa-question-circle ml-1" data-toggle="tooltip" data-placement="top" title="@lang('role.text.role_definition')"></i>
                        </th>
                        <th scope="col">@lang('role.field.description')</th>
                        <th scope="col" class="d-none d-md-table-cell">@lang('role.field.short_name')</th>
                        <th scope="col" class="d-none d-md-table-cell text-center">@lang('role.field.users')</th>
                        <th scope="col">&nbsp;</th>
                    </tr>
                @endslot

                @foreach($roles as $role)
                    <tr>
                        <td>{{ $role->display_name }}</td>
                        <td>{{ $role->description }}</td>
                        <td class="d-none d-md-table-cell">{{ $role->name }}</td>
                        <td class="d-none d-md-table-cell text-center">{{ $role->users_count }}</td>

                        <td class="text-right pr-3">
                            {{-- Edição do papel. --}}
                            @permission('admin.user.role.edit')
                                <a href="{{ route('admin.user.role.edit', ['role' => $role->id]) }}" class="text-dark" title="@lang('icon.update')">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            @endpermission

                            {{-- Modal - confirmação da exclusão do papel. --}}
                            @include('shared.form._confirm', [
                                'id' => 'role-destroy-'.$role->id, 
                                'buttonTitle' => trans('icon.destroy'),
                                'message' => trans('role.text.confirm_destroy', ['name' => $role->display_name]), 
                                'formOptions' => [
                                    'route' => [
                                        'admin.user.role.destroy',
                                        'id' => $role->id,
                                    ], 
                                    'method' => 'delete'
                                ],
                            ])
                            
                            {{-- Permissões do papel. --}}
                            @permission('admin.user.role.permission.index')
                                <a href="{{ route('admin.user.role.permission.index', ['role' => $role->id]) }}" class="text-dark ml-1" title="@lang('role.field.manage_permissions')">
                                    <i class="fa fa-cog"></i>
                                </a>
                            @endpermission
                        </td>

                    </tr>
                @endforeach

            @endcomponent
        </div>

        @if ($roles)
            <div class="box-footer py-3">
                <div class="text-center text-muted small">Total: {{ count($roles) }}</div>
            </div>
        @endif
    </div>

@endsection