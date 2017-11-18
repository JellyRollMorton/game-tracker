<template>

<div class="modal fade" id="add-player-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">



        <form>
          <div class="form-group">
            <label for="exampleInputEmail1">Name</label>
            <input type="email" class="form-control" id="addPlayerModalName" placeholder="Email">
          </div>
        </form>




      </div>
      <div class="modal-footer">
        <button type="button" v-on:click="addPlayerButtonClick" class="btn btn-primary">Add Player</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')            
        },
        methods: {
            addPlayerButtonClick: function(event) {
              var name = $('#addPlayerModalName').val();

              $.post( "/api/players", { 
                  name: name })
                .done(function( data ) {
                  $('#add-player-modal').modal('hide');
                });

                
            }
        }
    }
</script>
