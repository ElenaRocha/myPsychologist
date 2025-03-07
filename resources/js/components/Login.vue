<template>
  <form @submit.prevent="login">
    <input v-model="email" type="email" placeholder="Email" required>
    <input v-model="password" type="password" placeholder="Password" required>
    <button type="submit">Login</button>
  </form>
</template>

<script>
export default {
  data() {
    return {
      email: '',
      password: '',
    };
  },
  methods: {
    async login() {
      try {
        const response = await axios.post('/login', {
          email: this.email,
          password: this.password,
        });
        window.location.href = '/dashboard'; // Redirigir al dashboard
      } catch (error) {
        alert('Error al iniciar sesión');
      }
    },
  },
};
</script>