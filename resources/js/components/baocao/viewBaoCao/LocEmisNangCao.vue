<template>
    <div>
  <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <div class="panel panel-default">
      <div class="panel-heading" role="tab" id="headingOne">
        <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Lọc nâng cao
        </a>
      </h4>
      </div>
      <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
        <div class="panel-body">
            <p>{{demothoi}}</p>
            <input type="text" v-model="demothoi">
        </div>
      </div>
    </div>
  </div>
    </div>
</template>
<script>
    export default {
        props: ['info'],
        components: {
        },
        data() {
            return {
                demothoi:""
            }
        },
        mounted: function () {
        },
        methods: {
        }
    }
</script>
<style scoped>
</style>
