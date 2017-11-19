<template>

<div>
  <add-game-modal></add-game-modal>
  <add-player-modal></add-player-modal>

  <div class="toolbar-buttons pull-right">
    <a class="btn btn-primary" v-on:click="addPlayerButtonClick" href="#" role="button">Add Player</a>
    <a class="btn btn-primary" v-on:click="addGameButtonClick" href="#" role="button">Add Game</a>

  </div>

  <table id="example" class="table display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Rank</th>
                <th>Name</th>
                <th>Wins</th>
                <th>Losses</th>
            </tr>
        </thead>
    </table>
</div>

</template>

<script>
    export default {
        mounted() {
            console.log('Dashboard mounted.');

                  $(document).ready(function() {
          $('#example').DataTable( {
              "ajax": '/api/player_rankings'
          } );
      } );

        },
        methods: {
          addGameButtonClick: function(event) {
            $('#add-game-modal').modal();
          },

          addPlayerButtonClick: function(event) {
            $('#add-player-modal').modal();
          }          
        }
    }
</script>
