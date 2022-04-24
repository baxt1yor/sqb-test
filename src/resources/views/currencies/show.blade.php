@extends('layout.app')

@section('content')
    <div class="content">
        <button class="btn btn-warning text-white" type="button" data-mdb-toggle="modal" data-mdb-target="#exampleModal">Sync currencies</button>
        <a class="btn btn-primary text-white" href="{{ url('/') }}">Home</a>
    </div>
    <div class="content mt-5 mb-5">
        <ul class="list-group list-group-horizontal">
            <li class="list-group-item">ValuteId</li>
            <li class="list-group-item">NumCode</li>
            <li class="list-group-item">CharCode</li>
            <li class="list-group-item">Name</li>
        </ul>
        <ul class="list-group list-group-horizontal">
            <li class="list-group-item text-bold">{{ $currency->valuteId }}</li>
            <li class="list-group-item text-bold">{{ $currency->numCode }}</li>
            <li class="list-group-item text-bold">{{ $currency->charCode }}</li>
            <li class="list-group-item text-bold">{{ $currency->name }}</li>
        </ul>
    </div>
    <table class="table table-hover text-nowrap">
        <thead>
        <tr>
            <th scope="col">Date</th>
            <th scope="col">Nominal</th>
            <th scope="col">Value</th>
        </tr>
        </thead>
        <tbody>
        @foreach($currency->currencyChildes as $key => $children)
            <tr>
            <th scope="row">{{ $children->date }}</th>
            <td>
                {{ $children->nominal }}
            </td>
            <td>
                <span class="text-{{$key != 0 && $currency->currencyChildes[$key-1]->value > $children->value ? "danger" : "success" }}">
                  <i class="fas fa-caret-{{$key != 0 && $currency->currencyChildes[$key-1]->value > $children->value ? "down" : "up" }} me-1"></i><span>{{ $children->value }}</span>
                </span>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route("currency.child.sync") }}" method="POST">
                    @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sync currency children's</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                        <input type="hidden" name="valuteID" value="{{ $currency->valuteId }}">
                        <section class="w-100 p-4 d-flex justify-content-center pb-4">
                            <div class="form-outline datepicker" data-mdb-inline="true" style="width: 30rem;">
                                <input type="date" name="from" value="{{ old('from') }}" class="form-control" id="exampleDatepicker2" />
                                <label for="exampleDatepicker2" class="form-label">From date</label>
                            </div>
                        </section>
                        <section class="w-100 p-4 d-flex justify-content-center pb-4">
                            <div class="form-outline datepicker" data-mdb-inline="true" style="width: 30rem;">
                                <input type="date" name="to" value="{{old('to')}}" class="form-control" id="exampleDatepicker2" />
                                <label for="exampleDatepicker2" class="form-label">To date</label>
                            </div>
                        </section>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
