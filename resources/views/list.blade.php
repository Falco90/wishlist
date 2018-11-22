@extends('layout')
    @section('content')
    <div class="wrapper">
    <h2>{{ Auth::user()->name }}'s verlanglijstje</h2>
  
    <div id="items">
    <ul class="list-group">
    @foreach ($items as $item)
    <li class="list-group-item ourItem" data-toggle="modal" data-target="#exampleModal">{{ $item->item }}
    <input type="hidden" id="itemId" value="{{ $item->id }}">
    </li>
    @endforeach
      </ul>

    </div>
    <button type="button" class="btn btn-success" id="addNew" data-toggle="modal" data-target="#exampleModal">Voeg nieuwe wens toe</button>  

      <div class="modal" tabindex="-1" role="dialog" id="exampleModal">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="title">Nieuwe wens</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <input type="hidden" id="id">
              <p><input type="text" placeholder="Schrijf hier een nieuwe wens" id="addItem" class="form-control"></p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" id="delete" data-dismiss="modal" style="display:none">Verwijderen</button>
              <button type="button" class="btn btn-primary" id="saveChanges" data-dismiss="modal" style="display:none">Opslaan</button>
              <button type="button" class="btn btn-primary" id="addButton" data-dismiss="modal">Voeg nieuwe wens toe</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endsection
{{ csrf_field() }}
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <script>
    $(document).ready(function() {
      $(document).on('click', '.ourItem', function(event) {
                var text = $(this).text();
                var id = $(this).find('#itemId').val();
                $('#title').text('Wens aanpassen');
                $('#delete').show('400');
                $('#saveChanges').show('400');
                $('#addButton').hide();
                var text = $.trim(text);
                $('#addItem').val(text);
                $('#id').val(id);
                console.log(text);
        });
            $(document).on('click', '#addNew', function(event) {
                $('#title').text('Voeg nieuwe wens toe');
                $('#delete').hide('400');
                $('#saveChanges').hide('400');
                $('#addButton').show('400');
                $('#addItem').val("");
            });

            $('#addButton').click(function(event) {
                var text = $('#addItem').val();
                if (text == "") {
                  alert('Je hebt niets ingevuld');
                } else {
                $.post('list', {'text': text, '_token':$('input[name=_token]').val()}, function(data) {
                  console.log(data);
                  $('#items').load(location.href + ' #items');
                }).fail(function(e){console.log(e)
                });
                }
            });

            $('#delete').click(function(event) {
                var id = $('#id').val();
                $.post('delete', {'id': id, '_token':$('input[name=_token]').val()}, function(data) {
                  $('#items').load(location.href + ' #items');
                  console.log(data);
                });
            });

            $('#saveChanges').click(function(event) {
                var id = $('#id').val();
                var value = $('#addItem').val();
                $.post('update', {'id': id, 'value': value, '_token':$('input[name=_token]').val()}, function(data) {
                  $('#items').load(location.href + ' #items');
                  console.log(data);
                });
            });  
    });
    </script>
  </body>
</html>
