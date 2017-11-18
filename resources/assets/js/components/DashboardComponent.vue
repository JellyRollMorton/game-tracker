<template>

<div>
  <add-game-modal></add-game-modal>
  <add-player-modal></add-player-modal>

  <div class="toolbar-buttons pull-right">
    <a class="btn btn-primary" v-on:click="addPlayerButtonClick" href="#" role="button">Add Player</a>
    <a class="btn btn-primary" v-on:click="addGameButtonClick" href="#" role="button">Add Game</a>

  </div>
</div>

</template>

<script>
    export default {
        mounted() {
            console.log('Dashboard mounted.');
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
