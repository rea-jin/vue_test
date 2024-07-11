<template>
    <h1>{{ msg }}</h1>
    <div>
      <div>
        <input type="radio" id="local" value="1" v-model="selectedId">
        <label for="url1">URL 1: {{ apiUrl1 }}</label>
      </div>
      <div>
        <input type="radio" id="develop" value="2" v-model="selectedId">
        <label for="url2">URL 2: {{ apiUrl2 }}</label>
      </div>
  
      <textarea v-model="jsonInput" placeholder="JSONを入力してください"></textarea>
      <button @click="submitJson">送信</button>
  
      <div v-if="result">
        <h3>結果:</h3>
        <pre class="result">{{ result }}</pre>
      </div>
      <div ref="result" v-html="errorResponseHtml"></div> <!-- エラーレスポンスのHTMLを表示 -->
    </div>
  </template>
  
  <!-- 親から受け取るにはまずpropsへ -->
  <!-- dataに初期値を設定 -->
  <script>
  import { API_URL1, API_URL2, sendAPIPath } from '../../define.js';

  export default {
    name: "JsonSubmitter",
    data() {
      return {
        selectedId: "1",
        jsonInput: "",
        result: null,
        apiUrl1: API_URL1,
        apiUrl2: API_URL2, // 直接テンプレートに表示
        // selectMethod: 'GET',
        // pathParameter: '',
        // replaceParam: ''
        errorResponseHtml: "" // エラーレスポンスのHTMLを格納する変数
      }
    },
    props: {
      msg: String, // msgという名前のString型のpropsを定義
      selectedOption1: String, // 親コンポーネントから受け取るprops
      selectedOption2: String, // 親コンポーネントから受け取るprops
      selectMethod: String,
      pathParameter: String,
      replaceParam: String
    },
  //   watch: {
  //   // propsの値が変更されたらデータプロパティを更新
  //   selectMethodProp(newVal) {
  //     this.selectMethod = newVal;
  //   },
  //   pathParameterProp(newVal) {
  //     this.pathParameter = newVal;
  //   },
  //   replaceParamProp(newVal) {
  //     this.replaceParam = newVal;
  //   }
  // },
    mounted() {
      console.log("msg:", this.msg);
      console.log("selectedOption1:", this.selectedOption1);
      console.log("selectedOption2:", this.selectedOption2);
      console.log("apiurl1:", this.apiUrl1);
      console.log("apiurl2:", this.apiUrl2);
      // 新しいログ
      console.log("selectMethod:", this.selectMethod);
      console.log("pathParameter:", this.pathParameter);
      console.log("replaceParam:", this.replaceParam);
      
      // apiのレスポンスエラー時
      // if (this.$refs.result) {
      //   this.$refs.result.innerHTML = 'APIのレスポンスエラー';
      // } else {
      //   console.error('Element with ref "result" not found.'); // エラー処理
      // }
    },
    methods: {
      async submitJson() {
        try {
          const jsonData = {};
          let requestObj = {};
          // ここでjsonInputを解析してjsonDataに保存
          if (typeof jsonString === 'string') {
            try {
              requestObj = JSON.parse(this.jsonInput);
              console.log(this.jsonInput); // JSON文字列をパースしてオブジェクトに変換した結果を出力
            } catch (error) {
              console.error('Invalid JSON string:', error.message);
              return 'Invalid JSON string:' + error.message;
            }
          }else{
            requestObj = this.jsonInput;
          }
          jsonData['request'] = requestObj;

          // 選択されたIDによってURLを変更
          let sendUrl = sendAPIPath+"/send.php";
          let apiUrl = "";

          if(this.selectedId === "1") {
            apiUrl = API_URL1 + this.selectedOption1
          } else if(this.selectedId === "2") {
            apiUrl = API_URL2 + this.selectedOption2
          }
          // propsを直接使用
          console.log(apiUrl);
          jsonData["route"] = apiUrl
          const selectMethod = this.selectMethod
          console.log(selectMethod);
          jsonData["method"] = selectMethod
          const pathParameter = this.pathParameter
          console.log(pathParameter);
          jsonData["pathParameter"] = pathParameter
          const replaceParam = this.replaceParam
          console.log(replaceParam);
          jsonData["replaceParam"] = replaceParam

          // return;
          const response = await fetch(sendUrl, {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify(jsonData)
          })
          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`)
          }
          this.result = await response.json()
          this.errorResponseHtml = ""; // エラー時のHTML表示をクリア
        } catch (error) {
          this.errorResponseHtml = error.responseHTML || ""; // エラーレスポンスのHTMLを設定
          console.error("エラーが発生しました:", error)
          // htmlに表示
          this.result = { error: "JSONの解析または送信中にエラーが発生しました。" }
        }
      }
    },
   
  }
  </script>
  
  <style scoped>
  textarea {
    width: 50%;
    height: 300px;
    margin-bottom: 10px;
  }
  .result {
    background-color: #f0f0f0;
    padding: 10px;
    width: 80%;
    text-align: left;
    margin: 10px auto;
    
  }
  </style>