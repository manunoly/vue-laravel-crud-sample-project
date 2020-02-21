<template>
  <div>
    <h1>Person List</h1>

    <div v-if="errorMsg" class="alert alert-danger" role="alert">{{errorMsg}}</div>
    <div v-if="successMsg" class="alert alert-success" role="alert">{{successMsg}}</div>

    <div>
      <table class="table table-hover">
        <thead>
          <tr>
            <td>Name</td>
            <td>Last Name</td>
            <td>CI</td>
            <td></td>
          </tr>
        </thead>

        <tbody>
          <tr v-for="person in persons" :key="person.id">
            <td>{{ person.name }}</td>
            <td>{{ person.lastName }}</td>
            <td>{{ person.ci }}</td>
            <td>
              <router-link
                :to="{name: 'Edit', params: { id: person.id }}"
                class="btn btn-primary"
              >Edit</router-link>
            </td>
            <td>
              <button v-on:click="deletePerson(person.id)" class="btn btn-danger">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>


<script>
export default {
  data() {
    return {
      persons: [],
      errorMsg: "",
      successMsg: ""
    };
  },

  methods: {
    /**
     * Read data from server
     */
    async read() {
      this.mute = true;
      try {
        const response = await window.axios.get("/api/person");
        this.persons = response.data;
      } catch (error) {
        this.hadlerError(error);
      }
    },

    /**
     * Delete Person
     * @param id
     */
    async deletePerson(id) {
      try {
        // FIXME: improve desing, use vuejs-dialog
        if (confirm("Do you really want to delete?")) {
          const response = await window.axios.delete(`/api/person/${id}`);
          if (response && response.data) {
            this.successMsg = response.data;
            setTimeout(() => {
              this.successMsg = "";
            }, 3000);
          }
          await this.read();
        }
      } catch (error) {
        this.hadlerError(error);
      }
    },

    /**
     *  globlar error handler function
     * @param error
     */
    hadlerError(error) {
      if (
        error &&
        error.response &&
        error.response.data &&
        error.response.data.message
      )
        this.errorMsg = error.response.data.message;
      else this.errorMsg = "Unexpected error, please check the data and try again";
      setTimeout(() => {
        this.errorMsg = "";
      }, 3000);
    }
  },

  created() {
    this.read();
  }
};
</script>

<style>
</style>