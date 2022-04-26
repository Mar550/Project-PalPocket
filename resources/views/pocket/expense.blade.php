@extends('layouts.app')

@section('content')

<div class="container">
    <div>
        <h1 class="title"> Expense </h1>
        <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
  ADD NEW
</button>

<!-- Create Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">  NEW EXPENSE </h5>
        <br>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="form" method="POST" action="{{ route('expense.store') }}" enctype="multipart/form-data">
        @csrf
            <div class="input-group mb-3">
                <input id="description" class="form-control" type="text" placeholder="Description" name="description">
            </div>
            <span> {{ $errors->first('description')}} </span>
          

            <div class="input-group mb-3">
                <input id="amount" type="text" class="form-control" name="amount" placeholder="Amount" aria-label="Amount (to the nearest dollar)">
                <div class="input-group-append">
                    <span class="input-group-text"> € </span>
                </div>
            </div>
            <span> {{ $errors->first('amount')}} </span>


            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">Date</span>
                </div>
                <input type="date" id="date" class="form-control" name="date" aria-label="Default" aria-describedby="inputGroup-sizing-default">
            </div>
            <span> {{ $errors->first('date')}} </span>

            
            
            <div class="input-group mb-3">
                <input id="receipt" type="file" class="form-control" name="receipt"  >
    
            </div>
            <span> {{ $errors->first('receipt')}} </span>

            <div class="modal-footer">
        <button type="submit"  class="btn btn-primary"> Create </button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>

        </form>
        
      </div>
      
    </div>
  </div>
</div>
</div>
<br>
<br>
<!-- End Create Modal -->

<!-- EDIT MODAL -->
<div class="modal fade" id="staticBackdropEdit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">  EDIT EXPENSE </h5>
        <br>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="form" method="POST" action="{{ route('expense.update',$expense->id) }}"  enctype="multipart/form-data">
        @csrf
        @method('PUT')

            <div class="input-group mb-3">
                <input id="description" class="form-control" type="text" placeholder="Description" name="description" >
            </div>
            <span> {{ $errors->first('description')}} </span>
         

            <div class="input-group mb-3">
                <input id="amount" type="text" class="form-control" name="amount" placeholder="Amount" aria-label="Amount (to the nearest dollar)">
                <div class="input-group-append">
                    <span class="input-group-text"> € </span>
                </div>
            </div>
            <span> {{ $errors->first('amount')}} </span>


            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">Date</span>
                </div>
                <input type="date" id="date" class="form-control" name="date" aria-label="Default" aria-describedby="inputGroup-sizing-default">
            </div>
            <span> {{ $errors->first('date')}} </span>

            
            <div class="input-group mb-3">
                <input id="receipt" type="file" class="form-control" name="receipt"  >
   
            </div>
            <span> {{ $errors->first('receipt')}} </span>

            <div class="modal-footer">
        <button type="submit"  class="btn btn-primary"> Update </button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>

        </form>
        
      </div>
      
    </div>
  </div>
</div>
</div>
<br>
<br>
<!-- END EDIT MODAL -->


<!-- Table -->
<table id="example" class="table table-striped table-bordered" style="width:100%">

        <thead>
            <tr>
                <th id="thid">Id</th>
                <th id="thwording">Description</th>
                <th id="thamount">Amount</th>
                <th id="thdaet">Date</th>
                <th id="thinvoice">Receipt</th>
                <th>  </th>
            </tr>
        </thead>

        @forelse($expenses as $expense)

        <tbody>
            <tr>
                <td id='id'>{{ $expense->id }}</td>
                <td id='description'>{{ $expense->description }}</td>
                <td id='amount'>{{ $expense->amount }} €</td>
                <td id='date'>{{ $expense->date }}</td>
                <td id='receipt'>{{ $expense->receipt }}</td>
                <td> 
                    <div class="icones">
                    <a class="edit"  data-bs-toggle="modal" data-bs-target="#staticBackdropEdit"> <i id="editForm" class="fa-solid fa-pen-to-square"></i> </a>
                    <a class="delete" href="javascript:void(0)" > <i id="icone2" class="fa-solid fa-trash-can"> </i> </a>
                    </div>
                </td>
            </tr>   
        </tbody>
        @empty
        <tr>
            No income added 
        </tr>
        @endforelse
    </table>
</div>

<script type="text/javascript">

$('#form').on('submit',function(e){
    let description = $('#description').val();
    let amount = $('#amount').val();
    let date = $('#date').val();
    let receipt = $('#receipt').val();
    $.ajax({
      type:"POST",
      url: "/storeexpense",
      data:{
        "_token": "{{ csrf_token() }}",
        description:description,
        amount:amount,
        date:date,
        receipt:receipt,
      },
      success:function(response){
        $('#successMsg').show();
        console.log(response);
      },
      error: function(response) {
        $('#staticBackdrop').modal('show')
        $('#descriptionError').text(response.responseJSON.errors.description);
        $('#amountError').text(response.responseJSON.errors.amount);
        $('#dateError').text(response.responseJSON.errors.date);
        $('#receiptError').text(response.responseJSON.errors.receipt);
      },
    });
});



</script>

@endsection



