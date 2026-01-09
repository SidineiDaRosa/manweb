@extends('app.layouts.app')

@section('content')
<main class="content">
    <div class="container">

        <h2 class="mb-4">Business Partners</h2>

        <a href="{{ route('business-partners.create') }}" class="btn btn-primary mb-3">
            New Business Partner
        </a>

        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Type</th>
                    <th>Name</th>
                    <th>Document</th>
                    <th>Roles</th>
                    <th>Status</th>
                    <th width="150">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($businessPartners as $bp)
                <tr>
                    <td>{{ $bp->id }}</td>

                    <td>
                        {{ $bp->type == 'PF' ? 'Pessoa Física' : 'Pessoa Jurídica' }}
                    </td>

                    <td>
                        @if ($bp->type == 'PF')
                        {{ $bp->name_first }} {{ $bp->name_last }}
                        @else
                        {{ $bp->company_name }}
                        @endif
                    </td>

                    <td>{{ $bp->document }}</td>

                    <td>
                        @foreach ($bp->roles as $role)
                        <span class="badge bg-secondary">
                            {{ $role->role }}
                        </span>
                        @endforeach
                    </td>

                    <td>
                        <span class="badge {{ $bp->status == 'ATIVO' ? 'bg-success' : 'bg-danger' }}">
                            {{ $bp->status }}
                        </span>
                    </td>

                    <td>
                        <a href="{{ route('business-partners.show', $bp->id) }}"
                            class="btn btn-sm btn-info">
                            View
                        </a>

                        <a href="{{ route('business-partners.edit', $bp->id) }}"
                            class="btn btn-sm btn-warning">
                            Edit
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">
                        No business partners found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>
    @endsection
</main>