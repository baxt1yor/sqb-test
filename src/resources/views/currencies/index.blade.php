@extends('layout.app')

@section('content')
    <div class="content">
        <a class="btn btn-warning text-white" onclick="event.preventDefault(); document.getElementById('sync').submit()">Sync currencies</a>
        <form id="sync" action="{{ route("currency.sync") }}" method="POST">@csrf</form>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>ValuteId</th>
                    <th>NumCode</th>
                    <th>CharCode</th>
                    <th>Name</th>
                    <th>Created Time</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($currencies as $currency)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $currency->valuteId }}</td>
                        <td>{{ $currency->numCode }}</td>
                        <td>{{ $currency->charCode }}</td>
                        <td>{{ $currency->name }}</td>
                        <td>{{ $currency->created_at->format('Y-m-d') }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('currency.show', $currency->id) }}" class="btn btn-primary">Show currency children</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{$currencies->links()}}
    </div>
@endsection
