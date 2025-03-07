<template>
  <div>
    <h1>Perfil</h1>
    <form @submit.prevent="updateProfile">
      <input v-model="name" type="text" placeholder="Nombre" required>
      <input v-model="email" type="email" placeholder="Email" required>
      <button type="submit">Actualizar</button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      name: '',
      email: '',
    };
  },
  async created() {
    const response = await axios.get('/api/user');
    this.name = response.data.name;
    this.email = response.data.email;
  },
  methods: {
    async updateProfile() {
      try {
        await axios.put('/api/user', {
          name: this.name,
          email: this.email,
        });
        alert('Perfil actualizado');
      } catch (error) {
        alert('Error al actualizar el perfil');
      }
    },
  },
};
</script>