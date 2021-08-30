<x-app-layout>
<div class="container">
    <div class="row">
        <div class="col-md-12">
          @foreach($finance_reports as $finance_report)
          <div>{{$finance_report->title}}</div>
          @endforeach
        </div>
    </div>

</x-app-layout>