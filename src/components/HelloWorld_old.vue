<template>
  <div>
    <textarea
      v-model="jsonInput"
      placeholder="JSONを入力してください"
    ></textarea>
    <button @click="submitJson">送信</button>
    <div v-if="result">
      <h3>結果:</h3>
      <pre>{{ result }}</pre>
    </div>
  </div>
</template>

<script>
export default {
  name: "JsonSubmitter",
  data() {
    return {
      jsonInput: "",
      result: null,
    };
  },
  methods: {
    async submitJson() {
      try {
        const jsonData = JSON.parse(this.jsonInput);
        const response = await fetch("YOUR_API_ENDPOINT", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(jsonData),
        });
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        this.result = await response.json();
      } catch (error) {
        console.error("エラーが発生しました:", error);
        this.result = {
          error: "JSONの解析または送信中にエラーが発生しました。",
        };
      }
    },
  },
};
</script>

<style scoped>
textarea {
  width: 100%;
  height: 150px;
  margin-bottom: 10px;
}
</style>
