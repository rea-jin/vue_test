<template>
    <div>
      <label>Route 1:</label>
      <select v-model="selectedOption1">
        <!-- 受け取ったオブジェクトを展開 -->
        <option v-for="option in option1" :key="option.value" :value="option.value">
            {{ option.text }}
        </option>
      </select>
      
      <label>Route 2:</label>
      <select v-model="selectedOption2">
        <option v-for="option in option2" :key="option.value" :value="option.value">
            {{ option.text }}
        </option>
      </select>
    </div>
  </template>
  <!-- v-modelを使用して<select>要素の選択された値をselectedOption1とselectedOption2にバインドしています。
watchオプションを使用して、selectedOption1とselectedOption2の変更を監視し、変更があった場合に親コンポーネントにイベントを発行します ($emit)。 -->
  <script>
  import { OPT_ARR1, OPT_ARR2 } from '../../define.js';
  export default {
    data() {
      return {
        selectedOption1: '',
        selectedOption2: '',
        option1: [],
        option2: []
      };
    },
    watch: {
      selectedOption1(newValue) {
        this.$emit('update:selectedOption1', newValue);
      },
      selectedOption2(newValue) {
        this.$emit('update:selectedOption2', newValue);
      }
    },
    methods: {
      // オプションの配列を返す----2
      getOptions(optionArr) {
        // optionで受け取る
        return optionArr.map((option) => {
            // objectを返す
          return {
            value: option,
            text: option
          };
        });
      }
    },
    created() {
        // ドロップダウンメニュー用のオプションを設定---1
        const rawOptions1 = OPT_ARR1;
        this.option1 = this.getOptions(rawOptions1);
        const rawOptions2 = OPT_ARR2;
        this.option2 = this.getOptions(rawOptions2);
    }

  };
  </script>
  