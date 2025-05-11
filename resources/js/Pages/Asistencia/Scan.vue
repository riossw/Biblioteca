<template>
    <div class="p-6 text-center">
        <h2 class="text-2xl font-bold mb-4">Escanear Código QR para Asistencia</h2>

        <div v-if="mensaje" :class="`p-4 mb-4 rounded ${claseAlerta}`">{{ mensaje }}</div>

        <div id="qr-reader" style="width: 100%; max-width: 500px; margin: auto;"></div>

        <div v-if="qrTextoLeido" class="mt-4 p-3 bg-gray-100 text-sm text-gray-800 rounded border border-gray-300">
            <iframe :src="qrTextoLeido" width="100%" height="400" class="border rounded" allowfullscreen></iframe>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const mensaje = ref(null)
const claseAlerta = ref('bg-blue-100 text-blue-800')
const qrTextoLeido = ref(null)

onMounted(() => {
    const script = document.createElement('script')
    script.src = 'https://unpkg.com/html5-qrcode'
    script.onload = () => {
        const html5QrCode = new Html5Qrcode("qr-reader")

        html5QrCode.start(
            { facingMode: "environment" },
            {
                fps: 10,
                qrbox: 400,
                aspectRatio: 1.5,
                videoConstraints: {
                    width: { ideal: 1920 },
                    height: { ideal: 1080 }
                }
            },
            (decodedText, result) => {
                console.log('✅ QR escaneado:', decodedText)
                qrTextoLeido.value = decodedText // Mostrar texto leído
                html5QrCode.stop()

                try {
                    const url = new URL(decodedText)
                    const codigo = url.searchParams.get('codigo')
                    console.log('📦 Código extraído:', codigo)

                    if (!codigo) {
                        mensaje.value = 'QR inválido: falta el parámetro "codigo"'
                        claseAlerta.value = 'bg-red-100 text-red-800'
                        return
                    }

                    axios.post('/asistencia', { codigo })
                        .then(res => {
                            mensaje.value = res.data.message
                            claseAlerta.value = res.data.status === 'success'
                                ? 'bg-green-100 text-green-800'
                                : 'bg-yellow-100 text-yellow-800'
                        })
                        .catch(err => {
                            mensaje.value = err.response?.data?.message || 'Error en el registro'
                            claseAlerta.value = 'bg-red-100 text-red-800'
                        })

                } catch (e) {
                    console.error('❌ QR no válido:', decodedText)
                    mensaje.value = 'El QR escaneado no es un link válido'
                    claseAlerta.value = 'bg-red-100 text-red-800'
                }
            }
        )
    }

    document.body.appendChild(script)
})
</script>

//EXTRAER LOS DATOS DEL ESTUDIANTES.
//LA CAMARA QUE SE MANTENGA
