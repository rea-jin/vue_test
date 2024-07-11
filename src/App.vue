<template>
  <img alt="Vue logo" src="./assets/logo.png" />

  <!-- 子コンポーネント：RouteList -->
   <!-- 追加の処理がなければv-modelでいい -->
  <RouteList  
  @update:selectedOption1="handleOption1Change"
   @update:selectedOption2="handleOption2Change"
   v-model:selectMethod="selectMethod"
    v-model:pathParameter="pathParameter"
    v-model:replaceParam="replaceParam"
    />
  <!-- <p>Selected Option 1: {{ selectedOption1 }}</p> -->
  <!-- <p>Selected Option 2: {{ selectedOption2 }}</p> -->
  
  <!-- 子コンポーネント：JsonTest 親から子にわたすprops データが渡される。最初はreturnで設定したもの -->
  <JsonTest 
  msg="Welcome to JsonTest Vue.js App"
  :selectedOption1="selectedOption1"
  :selectedOption2="selectedOption2"
  :selectMethod="selectMethod"
  :pathParameter="pathParameter"
  :replaceParam="replaceParam"
  />
  <div>
    <!-- ルートコンポーネントの内部で動的にコンポーネントを切り替える -->
    <nav>
      <a href="#" @click.prevent="currentComponent = 'HomePage'">Home</a> |
      <a href="#" @click.prevent="currentComponent = 'AboutPage'">About</a>
    </nav>
    <component :is="currentComponent" :msg="msg" />

  </div>
</template>

<!-- ChildComponentをインポートし、テンプレート内で使用しています。 -->
<!-- @update:selectedOption1と@update:selectedOption2で子コンポーネントからのイベントを受け取り、それぞれのハンドラーメソッド (handleOption1ChangeとhandleOption2Change) を呼び出してデータを更新します。 -->
<script>
import JsonTest from "./components/JsonTest.vue";
import RouteList from "./components/RouteList.vue";

import HomePage from './HomePage.vue';
import AboutPage from './AboutPage.vue';

import { API_URL1, API_URL2 } from '../define.js';

export default {
  name: "App",
  components: {
    JsonTest,
    RouteList,
    HomePage,
    AboutPage
  },
  data() {
    return {
      selectedOption1: "/",
      selectedOption2: "/",
      currentComponent: "HomePage",
      apiurl1: API_URL1,
      apiurl2: API_URL2,
      // added
      // parentSelectMethod: 'GET',
      // parentPathParameter: '',
      // parentReplaceParam: ''
      selectMethod: 'GET',
        pathParameter: '',
        replaceParam: ''
    };
  },
  methods: {
    handleOption1Change(newValue) {
      this.selectedOption1 = newValue;
    },
    handleOption2Change(newValue) {
      this.selectedOption2 = newValue;
    }
  }
};
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
