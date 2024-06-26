<template>
    <div>
      <label>Option 1:</label>
      <select v-model="selectedOption1">
        <option value="option1a">Option 1A</option>
        <option value="option1b">Option 1B</option>
      </select>
      
      <label>Option 2:</label>
      <select v-model="selectedOption2">
        <option value="option2a">Option 2A</option>
        <option value="option2b">Option 2B</option>
      </select>
    </div>
  </template>
  <!-- v-modelを使用して<select>要素の選択された値をselectedOption1とselectedOption2にバインドしています。
watchオプションを使用して、selectedOption1とselectedOption2の変更を監視し、変更があった場合に親コンポーネントにイベントを発行します ($emit)。 -->
  <script>
  export default {
    data() {
      return {
        selectedOption1: '',
        selectedOption2: ''
      };
    },
    watch: {
      selectedOption1(newValue) {
        this.$emit('update:selectedOption1', newValue);
      },
      selectedOption2(newValue) {
        this.$emit('update:selectedOption2', newValue);
      }
    }
  };
  </script>
  