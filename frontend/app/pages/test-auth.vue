<template>
  <div style="padding: 2rem;">
    <button @click="login" style="margin-right: 1rem; padding: 0.5rem;">1. Login & Get Token</button>
    <button @click="fetchProtectedData" style="padding: 0.5rem;">2. Fetch Protected Route</button>

    <div style="margin-top: 1rem;">
      <strong>Current Token:</strong>
      <p>{{ token || 'No token yet' }}</p>
    </div>

    <div style="margin-top: 1rem;">
      <strong>Protected Route Response:</strong>
      <pre style="background: #eee; padding: 1rem;">{{ responseData }}</pre>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

// 1. Initialize Nuxt cookie to store the token securely
const token = useCookie('auth_token')
const responseData = ref(null)

// 2. Login Function (Step 2)
const login = async () => {
  try {
    const response = await $fetch('http://127.0.0.1:8000/api/v1/login', {
      method: 'POST',
      headers: {
        'Accept': 'application/json'
      },
      body: {
        // Change these to match a real user in your database
        phone: '+998998856458', 
        password: '$650KrescueMission'
      }
    })

    // Adjust 'response.token' if your API returns the token under a different key
    token.value = response.token 
    responseData.value = 'Login successful. Token saved to cookies.'
    
  } catch (error) {
    console.error('Login Failed:', error.data)
    responseData.value = error.data || 'Login failed (Check F12 Console)'
  }
}

// 3. Protected Fetch Function (Step 3)
const fetchProtectedData = async () => {
  if (!token.value) {
    responseData.value = 'Error: You must login first to get a token.'
    return
  }

  try {
    // Change this URL to your actual protected route (e.g., /api/v1/user or /api/v1/profile)
    const response = await $fetch('http://127.0.0.1:8000/api/v1/me', {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${token.value}`
      }
    })

    responseData.value = response
    
  } catch (error) {
    console.error('Protected Route Failed:', error.data)
    responseData.value = error.data || 'Unauthorized or CORS Error (Check F12 Console)'
  }
}
</script>