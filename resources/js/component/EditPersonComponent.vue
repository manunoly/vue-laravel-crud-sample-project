<template>
  <div class="container">
    <div v-if="editMode">
      <button v-on:click="setNewPerson" class="btn btn-link">Change to new Person</button>
    </div>

    <div class="card">
      <div class="card-header">
        <h3>{{editMode ? 'Edit' : 'Add'}} Person</h3>
      </div>

      <div v-if="errorMsg" class="alert alert-danger" role="alert">{{errorMsg}}</div>
      <div v-if="successMsg" class="alert alert-success" role="alert">{{successMsg}}</div>

      <div class="card-body">
        <form v-on:submit.prevent="actionPerson">
          <div class="form-group">
            <label>Name:</label>
            <input type="text" class="form-control" v-model="person.name" />
          </div>

          <div class="form-group">
            <label>Last Name:</label>
            <input type="text" class="form-control" v-model="person.lastName" />
          </div>

          <div class="form-group">
            <label>CI:</label>
            <input type="text" class="form-control" v-model="person.ci" />
          </div>

          <div class="form-group">
            <label>Email:</label>
            <input type="text" class="form-control" v-model="person.email" />
          </div>

          <div class="form-group">
            <input
              type="submit"
              class="btn btn-primary"
              :value="editMode ? 'Update Person' : 'Create Person' "
            />
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      person: {},
      editMode: false,
      errorMsg: "",
      successMsg: ""
    };
  },

  created: function() {
    this.getPerson();
  },

  methods: {
    /**
     * Verify if you going to edit or add person
     */
    actionPerson() {
      if (this.editMode) this.updatePerson();
      else this.addPerson();
    },

    /**
     * Get person data to edit
     */
    async getPerson() {
      console.log("route.params.id", this.$route.params.id);

      if (this.$route.params.id) {
        this.editMode = true;

        try {
          let uri = "api/person/" + this.$route.params.id;
          const response = await window.axios.get(uri);
          this.person = response.data;
        } catch (error) {
          this.hadlerError(error);
        }
      }
    },

    /**
     * Update person in database
     */
    async updatePerson() {
      // TODO: validate the data before submit according to bussines rules

      try {
        let uri = "api/person/" + this.$route.params.id;
        const response = await window.axios.put(uri, this.person);

        if (response && response.data) {
          this.successMsg = response.data;
          setTimeout(() => {
            this.successMsg = "";
            this.$router.push({ name: "Index" });
          }, 3000);
        }
      } catch (error) {
        this.hadlerError(error);
      }
    },

    /**
     * Add new person in database
     */
    async addPerson() {
      // TODO: validate the data before submit according to bussines rules
      try {
        let uri = "api/person/";
        const response = await window.axios.post(uri, this.person);

        if (response && response.data) {
          this.successMsg = response.data;
          setTimeout(() => {
            this.successMsg = "";
            this.$router.push({ name: "Index" });
          }, 3000);
        }
      } catch (error) {
        this.hadlerError(error);
      }
    },

    /**
     * Change edit to create
     */
    setNewPerson() {
      this.editMode = false;
      this.person = {};
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
      else
        this.errorMsg = "Unexpected error, please check the data and try again";
      setTimeout(() => {
        this.errorMsg = "";
      }, 3000);
    }
  }
};
</script>