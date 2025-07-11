<template>
  <div class="breadcrumb">
    <a class="breadcrumb-item" href="/dashboard">
      <span>Trang chủ </span>
    </a>

    <span class="icon icon-next"> <img :src="icon" class="img" /> </span>
    <a class="breadcrumb-item">
      <span>{{ menu }}</span>
    </a>

    <span class="icon icon-next"> <img :src="icon" class="img" /> </span>
    <a class="breadcrumb-item">
      <span :class="{ active: !subDesc }">{{ desc }}</span>
    </a>

    <span v-if="subDesc" class="icon icon-next"> <img :src="icon" class="img" /> </span>
    <a v-if="subDesc" class="breadcrumb-item">
      <span class="active">{{ subDesc }}</span>
    </a>

  </div>
</template>
<script>
import icon from "../../../../public/images/icon.svg";
export default {
  components: {},
  props: {
    menu: {
      type: String,
      require: true,
    },
    desc: {
      type: String,
      require: true,
    },
    subDesc : {
        type: String,
    }
  },
  watch: {},
  mounted() {},
  data() {
    return { icon };
  },
  methods: {},
};
</script>

<style scoped>
.breadcrumb {
  display: flex;
  -webkit-box-align: center;
  align-items: center;
  padding: 0px;
  margin: 0px;
}
a.breadcrumb-item {
  position: relative;
  display: flex;
  -webkit-box-pack: center;
  justify-content: center;
  -webkit-box-align: center;
  align-items: center;
  height: 40px;
  color: black;
  font-size: 15px;
  line-height: 20px;
  font-weight: 600;
  white-space: nowrap;
  text-decoration: none;
}

.icon.icon-next {
  margin-left: 5.5px;
  margin-right: 8.5px;
}

.icon {
  display: inline-block;
  vertical-align: middle;
  background-repeat: no-repeat;
  background-position: 0px 0px;
}
.img {
  margin-bottom: 5px;
}
.active {
  color: #044e93;
}
</style>
