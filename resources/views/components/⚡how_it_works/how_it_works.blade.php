<div class="min-h-screen bg-white dark:bg-[#1D293D]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20">

        <div class="text-center mb-16">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-slate-900 dark:text-white mb-4">
                ¿Cómo Funciona?
            </h1>
            <div class="w-24 h-1 bg-blue-600 mx-auto mb-6"></div>
            <p class="text-xl text-slate-600 dark:text-slate-300 max-w-3xl mx-auto">
                Participa en las encuestas electorales de manera simple, segura y transparente
            </p>
        </div>

        <div class="grid lg:grid-cols-2 gap-8 mb-20">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl p-8 border-t-4 border-green-600 transform hover:-translate-y-2 transition-all duration-300">
                <div class="w-16 h-16 bg-green-100 dark:bg-green-900/50 rounded-full flex items-center justify-center mb-6 mx-auto">
                    <span class="text-3xl font-bold text-green-600 dark:text-green-400">1</span>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-4 text-center">Explora</h3>
                <p class="text-slate-600 dark:text-slate-300 text-center leading-relaxed">
                    Consulta las encuestas activas filtrándolas según el ámbito de la encuesta: regional, provincial o distrital.
                </p>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl p-8 border-t-4 border-purple-600 transform hover:-translate-y-2 transition-all duration-300">
                <div class="w-16 h-16 bg-purple-100 dark:bg-purple-900/50 rounded-full flex items-center justify-center mb-6 mx-auto">
                    <span class="text-3xl font-bold text-purple-600 dark:text-purple-400">2</span>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-4 text-center">Vota</h3>
                <p class="text-slate-600 dark:text-slate-300 text-center leading-relaxed">
                    Emite tu voto de manera segura. Podrás ver los resultados en tiempo real una vez que hayas participado.
                </p>
            </div>
        </div>

        <div class="mb-20" x-data="{ activeTab: 'encuestas' }">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl overflow-hidden">
                <div class="border-b border-slate-200 dark:border-slate-700">
                    <nav class="flex flex-wrap -mb-px">
                        <button @click="activeTab = 'encuestas'" :class="activeTab === 'encuestas' ? 'border-blue-600 text-blue-600 dark:text-blue-400' : 'border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300 hover:border-slate-300 dark:hover:border-slate-600'" class="w-full sm:w-auto flex-1 sm:flex-none py-4 px-6 text-center border-b-2 font-medium text-sm transition-colors">
                            Encuestas
                        </button>
                        <button @click="activeTab = 'votacion'" :class="activeTab === 'votacion' ? 'border-blue-600 text-blue-600 dark:text-blue-400' : 'border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300 hover:border-slate-300 dark:hover:border-slate-600'" class="w-full sm:w-auto flex-1 sm:flex-none py-4 px-6 text-center border-b-2 font-medium text-sm transition-colors">
                            Proceso de Votación
                        </button>
                    </nav>
                </div>

                <div class="p-8 sm:p-12">
                    <div x-show="activeTab === 'encuestas'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" style="display: none;">
                        <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-6">Exploración de Encuestas</h2>

                        <div class="space-y-6">
                            <div>
                                <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-4">Información de cada Encuesta</h3>
                                <p class="text-slate-600 dark:text-slate-300 mb-4">
                                    En el listado de encuestas encontrarás toda la información relevante para tu participación:
                                </p>

                                <div class="bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg p-6 space-y-4">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 w-8 h-8 bg-blue-100 dark:bg-blue-900/50 rounded-full flex items-center justify-center mr-3">
                                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-medium text-slate-900 dark:text-white">Título de la Encuesta</p>
                                            <p class="text-sm text-slate-600 dark:text-slate-400">Ejemplo: "Elecciones Presidenciales 2026 - Primera Vuelta"</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 w-8 h-8 bg-green-100 dark:bg-green-900/50 rounded-full flex items-center justify-center mr-3">
                                            <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-medium text-slate-900 dark:text-white">Fechas de Vigencia</p>
                                            <p class="text-sm text-slate-600 dark:text-slate-400">Fecha de inicio y finalización de la encuesta</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 w-8 h-8 bg-purple-100 dark:bg-purple-900/50 rounded-full flex items-center justify-center mr-3">
                                            <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-medium text-slate-900 dark:text-white">Total de Votos</p>
                                            <p class="text-sm text-slate-600 dark:text-slate-400">Cantidad de personas que han participado</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-4">Estados de Encuestas</h3>
                                <div class="grid md:grid-cols-2 gap-4">
                                    <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                                        <div class="flex items-center mb-2">
                                            <span class="w-3 h-3 bg-green-500 dark:bg-green-400 rounded-full mr-2"></span>
                                            <span class="font-semibold text-green-900 dark:text-green-300">Encuestas Activas</span>
                                        </div>
                                        <p class="text-sm text-green-800 dark:text-green-400">Puedes participar votando por tu candidato preferido</p>
                                    </div>

                                    <div class="bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg p-4">
                                        <div class="flex items-center mb-2">
                                            <span class="w-3 h-3 bg-slate-500 dark:bg-slate-400 rounded-full mr-2"></span>
                                            <span class="font-semibold text-slate-900 dark:text-slate-300">Encuestas Finalizadas</span>
                                        </div>
                                        <p class="text-sm text-slate-700 dark:text-slate-400">Puedes ver los resultados finales pero no votar</p>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-4">Partidos Políticos</h3>
                                <p class="text-slate-600 dark:text-slate-300 mb-4">
                                    En la sección de partidos políticos encontrarás:
                                </p>
                                <ul class="space-y-2">
                                    <li class="flex items-start">
                                        <svg class="w-5 h-5 text-blue-500 dark:text-blue-400 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="text-slate-700 dark:text-slate-300">Información completa de cada partido político</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-5 h-5 text-blue-500 dark:text-blue-400 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="text-slate-700 dark:text-slate-300">Descripción de sus propuestas e ideología</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-5 h-5 text-blue-500 dark:text-blue-400 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="text-slate-700 dark:text-slate-300">Información de contacto oficial</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-5 h-5 text-blue-500 dark:text-blue-400 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="text-slate-700 dark:text-slate-300">Listado de candidatos por partido</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div x-show="activeTab === 'votacion'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" style="display: none;">
                        <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-6">Proceso de Votación</h2>

                        <div class="space-y-8">
                            <div>
                                <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-4">Pasos para Votar</h3>

                                <div class="space-y-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0 w-10 h-10 bg-blue-600 dark:bg-blue-500 text-white rounded-full flex items-center justify-center font-bold mr-4">1</div>
                                        <div class="flex-1 pt-1">
                                            <h4 class="font-semibold text-slate-900 dark:text-white mb-1">Selecciona una Encuesta</h4>
                                            <p class="text-slate-600 dark:text-slate-300">Navega por las encuestas activas y haz clic en la que deseas participar.</p>
                                        </div>
                                    </div>

                                    <div class="flex">
                                        <div class="flex-shrink-0 w-10 h-10 bg-blue-600 dark:bg-blue-500 text-white rounded-full flex items-center justify-center font-bold mr-4">2</div>
                                        <div class="flex-1 pt-1">
                                            <h4 class="font-semibold text-slate-900 dark:text-white mb-1">Revisa los Detalles</h4>
                                            <p class="text-slate-600 dark:text-slate-300">Lee la descripción de la encuesta, las fechas y los candidatos participantes.</p>
                                        </div>
                                    </div>

                                    <div class="flex">
                                        <div class="flex-shrink-0 w-10 h-10 bg-blue-600 dark:bg-blue-500 text-white rounded-full flex items-center justify-center font-bold mr-4">3</div>
                                        <div class="flex-1 pt-1">
                                            <h4 class="font-semibold text-slate-900 dark:text-white mb-1">Explora la Tabla de Candidatos</h4>
                                            <p class="text-slate-600 dark:text-slate-300 mb-2">La tabla muestra información de cada candidato:</p>
                                            <ul class="text-sm text-slate-600 dark:text-slate-400 space-y-1 ml-4">
                                                <li>• Nombre del candidato</li>
                                                <li>• Partido político</li>
                                                <li>• Porcentaje de votos actual</li>
                                                <li>• Número total de votos recibidos</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="flex">
                                        <div class="flex-shrink-0 w-10 h-10 bg-blue-600 dark:bg-blue-500 text-white rounded-full flex items-center justify-center font-bold mr-4">4</div>
                                        <div class="flex-1 pt-1">
                                            <h4 class="font-semibold text-slate-900 dark:text-white mb-1">Elige tu Opción de Voto</h4>
                                            <p class="text-slate-600 dark:text-slate-300 mb-2">Tienes varias opciones disponibles:</p>
                                            <div class="grid sm:grid-cols-3 gap-3 mt-3">
                                                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-3 text-center">
                                                    <div class="font-semibold text-green-900 dark:text-green-300 text-sm">Candidato</div>
                                                    <p class="text-xs text-green-700 dark:text-green-400 mt-1">Vota por un candidato específico</p>
                                                </div>
                                                <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-3 text-center">
                                                    <div class="font-semibold text-yellow-900 dark:text-yellow-300 text-sm">No sabe / No opina</div>
                                                    <p class="text-xs text-yellow-700 dark:text-yellow-400 mt-1">No tengo una opinión clara o no tengo preferencia</p>
                                                </div>
                                                <div class="bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg p-3 text-center">
                                                    <div class="font-semibold text-slate-900 dark:text-slate-300 text-sm">Ninguno de los anteriores</div>
                                                    <p class="text-xs text-slate-700 dark:text-slate-400 mt-1">Ninguno de las opciones me representa o que no votaría</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex">
                                        <div class="flex-shrink-0 w-10 h-10 bg-blue-600 dark:bg-blue-500 text-white rounded-full flex items-center justify-center font-bold mr-4">5</div>
                                        <div class="flex-1 pt-1">
                                            <h4 class="font-semibold text-slate-900 dark:text-white mb-1">Confirma tu Voto</h4>
                                            <p class="text-slate-600 dark:text-slate-300">Haz clic en el botón "Marcar" de tu opción elegida. Se te pedirá confirmar tu decisión.</p>
                                        </div>
                                    </div>

                                    <div class="flex">
                                        <div class="flex-shrink-0 w-10 h-10 bg-green-600 dark:bg-green-500 text-white rounded-full flex items-center justify-center font-bold mr-4">✓</div>
                                        <div class="flex-1 pt-1">
                                            <h4 class="font-semibold text-slate-900 dark:text-white mb-1">Voto Registrado</h4>
                                            <p class="text-slate-600 dark:text-slate-300">Recibirás un mensaje de confirmación y podrás ver los resultados actualizados inmediatamente.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-4">Resultados de la Encuesta</h3>
                                <p class="text-slate-600 dark:text-slate-300 mb-4">
                                    Después de votar, verás el resumen completo de la encuesta:
                                </p>
                                <div class="bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg p-6">
                                    <div class="grid md:grid-cols-3 gap-4 text-center">
                                        <div>
                                            <div class="text-3xl font-bold text-blue-600 dark:text-blue-400 mb-1">📊</div>
                                            <div class="text-sm font-semibold text-slate-900 dark:text-white">Total de Votos</div>
                                            <div class="text-xs text-slate-600 dark:text-slate-400 mt-1">Participación general</div>
                                        </div>
                                        <div>
                                            <div class="text-3xl font-bold text-yellow-600 dark:text-yellow-400 mb-1">❓</div>
                                            <div class="text-sm font-semibold text-slate-900 dark:text-white">Votos No Sabe / No Opina</div>
                                            <div class="text-xs text-slate-600 dark:text-slate-400 mt-1">No tengo una opinión clara o no tengo preferencia</div>
                                        </div>
                                        <div>
                                            <div class="text-3xl font-bold text-slate-600 dark:text-slate-400 mb-1">⬜</div>
                                            <div class="text-sm font-semibold text-slate-900 dark:text-white">Ninguno de los anteriores</div>
                                            <div class="text-xs text-slate-600 dark:text-slate-400 mt-1">Ninguno de las opciones me representa o que no votaría</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-6">
                                <h3 class="text-lg font-bold text-red-900 dark:text-red-300 mb-3 flex items-center">
                                    <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    Reglas Importantes
                                </h3>
                                <ul class="space-y-2 text-red-800 dark:text-red-300 text-sm">
                                    <li class="flex items-start">
                                        <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                        Solo puedes votar UNA VEZ por encuesta
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                        No podrás cambiar tu voto una vez confirmado
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                        Tu voto es anónimo - no se asocia públicamente con tu identidad
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
