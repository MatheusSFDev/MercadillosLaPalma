import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            screens: {
                    '4k': '2560px',
                },
            colors: {
                
                // --- COLORES CORPORATIVOS (Basados en pág. 6 Guía de Estilos) ---

                // Verde Principal (Botones, Enlaces importantes, Iconos activos)
                primary: {
                    DEFAULT: '#2b5c01', // El verde oscuro fuerte [cite: 441]
                    hover: '#5a8713', // Verde hoja más vivo para hovers [cite: 441]
                    light: '#7c995c', // Verde salvia para bordes o fondos suaves [cite: 441]
                    pastel: '#e3eccd', // Verde pastel para fondos o tarjetas [cite: 441]
                },

                // Tonos Tierra (Textos, Fondos secundarios)
                coffee: {
                    DEFAULT: '#38250f', // Marrón café (Ideal para Títulos y Texto principal) [cite: 441]
                    light: '#8b5e3c', // Marrón medio (Para subtítulos o textos menos importantes) [cite: 441]
                    soft: '#d4a066', // Ocre claro (Detalles, fondos de tarjetas) [cite: 441]
                },

                // Acentos y Utilidades
                accent: {
                    orange: '#ff751f', // Naranja cálido (Llamados a la acción, Iconos destacados) [cite: 441]
                    yellow: '#f3b93c', // Mostaza (Para destacar ofertas o estrellas) [cite: 441]
                    cream: '#c8c286', // Beige verdoso (Fondos alternativos) [cite: 441]
                    olive: '#4d5d3d', // Verde oliva oscuro (Para pies de página o bloques oscuros) [cite: 441]
                },

                // Estados del Sistema
                status: {
                    error: '#a61523', // Rojo intenso (Validaciones, Borrar) [cite: 441]
                    dark: '#0f1b07', // Casi negro (Para textos que necesitan máximo contraste) [cite: 441]
                    white: '#ffffff', // Blanco puro [cite: 441]
                }
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                'playfair': ['"Playfair Display"', ...defaultTheme.fontFamily.serif],
                'dm-serif': ['"DM Serif Display"', ...defaultTheme.fontFamily.serif],
                'atkinson': ['"Atkinson Hyperlegible"', ...defaultTheme.fontFamily.sans],
                'titulo-principal': ['"Black Mango"', ...defaultTheme.fontFamily.serif],
                'titulo-seccion': ['Playfair', ...defaultTheme.fontFamily.serif],
                'subtitulo': ['"DM Serif"', ...defaultTheme.fontFamily.serif],
                'general': ['Atkinson', ...defaultTheme.fontFamily.serif],
                'open-sans': ['"Open Sans"', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
