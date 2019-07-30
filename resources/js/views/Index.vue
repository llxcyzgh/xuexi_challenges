<template>
  <div class="index">
    <div class="loading" v-if="isLoading">
      Loading ...
    </div>

    <div class="search">
      <label for="search">Search</label>
      <input v-model="keyword" type="text" id="search" @input="onSearch" class="input_search"
             placeholder="问题或选项关键词">
    </div>

    <ul v-if="list && list.length">
      <li>
        <ul>
          <li class="li_is_verified">Id</li>
          <li>Question</li>
          <li class="li_provenance">Provenance</li>
          <li class="li_options">Options</li>
          <li class="li_answer">Answer</li>
          <li class="li_is_verified">Is_verified</li>
        </ul>
      </li>

      <li v-for="(item, index) in list">
        <ul>
          <li class="li_is_verified">{{ item.id ? item.id : index + 1 }}</li>
          <li>{{ item.question }}</li>
          <li class="li_provenance">{{ item.provenance }}</li>
          <li class="li_options" v-html="item.options"></li>
          <li class="li_answer" style="background-color: #ff0;">{{ item.answer }}</li>
          <li class="li_is_verified">{{ item.is_verified ? '是' : '否' }}</li>
        </ul>
      </li>
    </ul>

    <ul v-if="(!list || !list.length) && !isLoading">
      <li>
        <ul>
          <li class="li_is_verified">Id</li>
          <li>Question</li>
          <li class="li_provenance">Provenance</li>
          <li class="li_options">Options</li>
          <li class="li_answer">Answer</li>
          <li class="li_is_verified">Is_verified</li>
        </ul>
      </li>
      <li style="text-align: center; margin-top: 10px">
        暂无数据~
      </li>
    </ul>
  </div>
</template>

<script>
  import axios from 'axios'

  export default {
    name: "Index",
    data() {
      return {
        isLoading: false,
        list: [],
        error: null,
        keyword: '',
        keyword_old: '',
        timeOut: null,
        current_page: 0,
        total_page: 0
      }
    },
    mounted() {
      window.addEventListener('scroll', this.fetchData)
    },
    created() {
      this.fetchData(true)
    },
    methods: {
      async fetchData() {
        if (!this.current_page) {
          this.current_page = 1
          let getResponse = await axios.get('/api/questions')
          this.list = getResponse.data.data
          this.total_page = getResponse.data.last_page
          this.isLoading = false

          return
        }

        let bottomOfWindow = document.documentElement.offsetHeight - document.documentElement.scrollTop - window.innerHeight <= 200
        if (!this.isLoading && bottomOfWindow && this.current_page < this.total_page) {
          this.error = null
          this.isLoading = true
          this.current_page++
          let getResponse = await axios.get('/api/questions?page=' + this.current_page)

          this.list.push(...getResponse.data.data)
          this.total_page = getResponse.data.last_page
          this.isLoading = false
        }
      },

      onSearch() {
        if (this.keyword === this.keyword_old) {
          return
        }

        this.keyword_old = this.keyword

        clearTimeout(this.timeOut)
        if (!this.keyword) {
          this.current_page = 0
          this.fetchData()
          return
        } else if (this.keyword.length < 2) {
          return
        }

        this.timeOut = setTimeout(() => {
          this.searchQuestion(this.keyword)
        }, 600)
      },

      async searchQuestion(keyword) {
        try {
          let searchResponse = await axios.get('/api/questions/search?keyword=' + keyword)
          this.list = searchResponse.data
        } catch (e) {
          console.log(e)
        }
      }
    }

  }
</script>

<style scoped>
  * {
    margin: 0;
    padding: 0;
  }

  .loading {
    width: 100px;
    margin: 0 auto 30px auto;
  }

  .search {
    width: 300px;
    margin: 0 auto;
  }

  .input_search {
    height: 30px;
    border-radius: 10px;
    padding: 0 10px;
    border: 1px solid #bbb;
  }

  ul {
    list-style: none;
  }

  ul li ul {
    border-bottom: 1px solid #ccc;
    /*background-color: #0f0;*/
    /*overflow: hidden;*/
    display: flex;
    align-items: center;
    /*display: table-cell;*/
    /*vertical-align: middle;*/
  }

  ul li ul li {
    width: 500px;
    /*border-right: 1px solid #ccc;*/
    padding: 10px;
    /*border-bottom: 1px solid #ccc;*/
    margin-bottom: 10px;
  }

  ul li ul li:last-child {
    border-right: none;
  }

  .li_provenance {
    width: 100px;
    font-size: 10px;
  }

  .li_options {
    width: 300px;
  }

  .li_answer {
    width: 200px;
  }

  .li_is_verified {
    width: 30px;
  }
</style>
