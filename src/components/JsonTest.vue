<template>
    <h1>{{ msg }}</h1>
    <div>
      <div>
        <input type="radio" id="local" value="1" v-model="selectedId">
        <label for="url1">URL 1: local</label>
      </div>
      <div>
        <input type="radio" id="develop" value="2" v-model="selectedId">
        <label for="url2">URL 2: develop</label>
      </div>
  
      <textarea v-model="jsonInput" placeholder="JSONを入力してください"></textarea>
      <button @click="submitJson">送信</button>
  
      <div v-if="result">
        <h3>結果:</h3>
        <pre>{{ result }}</pre>
      </div>
    </div>
  </template>
  
  <script>
  import { API_URL1, API_RUL2 } from '../../define.js';

  export default {
    name: "JsonSubmitter",
    data() {
      return {
        selectedId: "1",
        jsonInput: "",
        result: null
      }
    },
    props: {
      msg: String, // msgという名前のString型のpropsを定義
      selectedOption1: String, // 親コンポーネントから受け取るprops
      selectedOption2: String // 親コンポーネントから受け取るprops
    },
    mounted() {
    console.log("msg:", this.msg);
    console.log("selectedOption1:", this.selectedOption1);
    console.log("selectedOption2:", this.selectedOption2);
  },
    methods: {
      async submitJson() {
        try {
          // 選択されたIDによってURLを変更
          let apiUrl = "";
          console.log(this.selectedId);
          console.log(this.selectedOption1);
          console.log(this.selectedOption2);
          if(this.selectedId === "1") {
            apiUrl = API_URL1 + this.selectedOption1
          } else if(this.selectedId === "2") {
            apiUrl = API_RUL2 + this.selectedOption2
          }
          console.log(apiUrl);
          return;
          // const response = await fetch(apiUrl, {
          //   method: "POST",
          //   headers: {
          //     "Content-Type": "application/json",
          //   },
          //   body: JSON.stringify(jsonData)
          // })
          // if (!response.ok) {
          //   throw new Error(`HTTP error! status: ${response.status}`)
          // }
          // this.result = await response.json()
        } catch (error) {
          console.error("エラーが発生しました:", error)
          this.result = { error: "JSONの解析または送信中にエラーが発生しました。" }
        }
      }
    },
   
  }
  </script>
  
  <style scoped>
  textarea {
    width: 100%;
    height: 150px;
    margin-bottom: 10px;
  }
  </style>