<div class="min-h-screen bg-white dark:bg-[#1D293D]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20">

        <div class="text-center mb-16">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-slate-900 dark:text-white mb-4">
                ¿Cómo funciona?
            </h1>
            <div class="w-24 h-1 bg-indigo-600 mx-auto mb-6"></div>
            <p class="text-xl text-slate-600 dark:text-slate-300 max-w-3xl mx-auto">
                Participa en encuestas universitarias de forma simple, segura y accionable para mejorar la experiencia académica.
            </p>
        </div>

        <div class="grid lg:grid-cols-2 gap-8 mb-20">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl p-8 border-t-4 border-emerald-600 transform hover:-translate-y-2 transition-all duration-300">
                <div class="w-16 h-16 bg-emerald-100 dark:bg-emerald-900/50 rounded-full flex items-center justify-center mb-6 mx-auto">
                    <span class="text-3xl font-bold text-emerald-600 dark:text-emerald-400">1</span>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-4 text-center">Explora</h3>
                <p class="text-slate-600 dark:text-slate-300 text-center leading-relaxed">
                    Consulta encuestas por docentes, cursos, servicios y áreas de la universidad según tu interés y tu perfil.
                </p>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl p-8 border-t-4 border-indigo-600 transform hover:-translate-y-2 transition-all duration-300">
                <div class="w-16 h-16 bg-indigo-100 dark:bg-indigo-900/50 rounded-full flex items-center justify-center mb-6 mx-auto">
                    <span class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">2</span>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-4 text-center">Responde</h3>
                <p class="text-slate-600 dark:text-slate-300 text-center leading-relaxed">
                    Marca tu nivel de satisfacción con un proceso rápido, seguro y pensado para la toma de decisiones institucionales.
                </p>
            </div>
        </div>

        <div class="mb-20" x-data="{ activeTab: 'encuestas' }">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl overflow-hidden">
                <div class="border-b border-slate-200 dark:border-slate-700">
                    <nav class="flex flex-wrap -mb-px">
                        <button @click="activeTab = 'encuestas'" :class="activeTab === 'encuestas' ? 'border-indigo-600 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300 hover:border-slate-300 dark:hover:border-slate-600'" class="w-full sm:w-auto flex-1 sm:flex-none py-4 px-6 text-center border-b-2 font-medium text-sm transition-colors">
                            Encuestas
                        </button>
                        <button @click="activeTab = 'proceso'" :class="activeTab === 'proceso' ? 'border-indigo-600 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300 hover:border-slate-300 dark:hover:border-slate-600'" class="w-full sm:w-auto flex-1 sm:flex-none py-4 px-6 text-center border-b-2 font-medium text-sm transition-colors">
                            Proceso
                        </button>
                    </nav>
                </div>

                <div class="p-8 sm:p-12">
                    <div x-show="activeTab === 'encuestas'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" style="display: none;">
                        <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-6">Exploración académica</h2>

                        <div class="space-y-6">
                            <div>
                                <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-4">Información de cada encuesta</h3>
                                <p class="text-slate-600 dark:text-slate-300 mb-4">
                                    En cada encuesta encontrarás la información clave para dar una respuesta útil y representativa:
                                </p>

                                <div class="bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg p-6 space-y-4">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 w-8 h-8 bg-indigo-100 dark:bg-indigo-900/50 rounded-full flex items-center justify-center mr-3">
                                            <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-medium text-slate-900 dark:text-white">Título y objetivo</p>
                                            <p class="text-sm text-slate-600 dark:text-slate-400">Ejemplo: "Evaluación del curso de Matemáticas II"</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 w-8 h-8 bg-emerald-100 dark:bg-emerald-900/50 rounded-full flex items-center justify-center mr-3">
                                            <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-medium text-slate-900 dark:text-white">Fechas de aplicación</p>
                                            <p class="text-sm text-slate-600 dark:text-slate-400">Vigencia y cierre de la encuesta</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 w-8 h-8 bg-violet-100 dark:bg-violet-900/50 rounded-full flex items-center justify-center mr-3">
                                            <svg class="w-4 h-4 text-violet-600 dark:text-violet-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-medium text-slate-900 dark:text-white">Participación total</p>
                                            <p class="text-sm text-slate-600 dark:text-slate-400">Cantidad de respuestas recibidas</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-4">Tipos de encuestas</h3>
                                <div class="grid md:grid-cols-2 gap-4">
                                    <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-lg p-4">
                                        <div class="flex items-center mb-2">
                                            <span class="w-3 h-3 bg-emerald-500 dark:bg-emerald-400 rounded-full mr-2"></span>
                                            <span class="font-semibold text-emerald-900 dark:text-emerald-300">Activas</span>
                                        </div>
                                        <p class="text-sm text-emerald-800 dark:text-emerald-400">Estudiantes y docentes pueden responder y aportar opinión en tiempo real.</p>
                                    </div>

                                    <div class="bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg p-4">
                                        <div class="flex items-center mb-2">
                                            <span class="w-3 h-3 bg-slate-500 dark:bg-slate-400 rounded-full mr-2"></span>
                                            <span class="font-semibold text-slate-900 dark:text-slate-300">Cerradas</span>
                                        </div>
                                        <p class="text-sm text-slate-700 dark:text-slate-400">Se visualizan resultados finales para análisis institucional.</p>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-4">Enfoques de mejora</h3>
                                <p class="text-slate-600 dark:text-slate-300 mb-4">
                                    La plataforma está pensada para evaluar:
                                </p>
                                <ul class="space-y-2">
                                    <li class="flex items-start">
                                        <svg class="w-5 h-5 text-indigo-500 dark:text-indigo-400 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="text-slate-700 dark:text-slate-300">Satisfacción docente y metodologías</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-5 h-5 text-indigo-500 dark:text-indigo-400 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="text-slate-700 dark:text-slate-300">Calidad de cursos y plan de estudios</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-5 h-5 text-indigo-500 dark:text-indigo-400 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="text-slate-700 dark:text-slate-300">Servicios universitarios y bienestar estudiantil</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div x-show="activeTab === 'proceso'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" style="display: none;">
                        <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-6">Proceso de participación</h2>

                        <div class="space-y-8">
                            <div>
                                <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-4">Pasos para responder</h3>

                                <div class="space-y-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0 w-10 h-10 bg-indigo-600 dark:bg-indigo-500 text-white rounded-full flex items-center justify-center font-bold mr-4">1</div>
                                        <div class="flex-1 pt-1">
                                            <h4 class="font-semibold text-slate-900 dark:text-white mb-1">Selecciona la encuesta</h4>
                                            <p class="text-slate-600 dark:text-slate-300">Elige la evaluación que corresponde a tu curso, facultad o servicio.</p>
                                        </div>
                                    </div>

                                    <div class="flex">
                                        <div class="flex-shrink-0 w-10 h-10 bg-indigo-600 dark:bg-indigo-500 text-white rounded-full flex items-center justify-center font-bold mr-4">2</div>
                                        <div class="flex-1 pt-1">
                                            <h4 class="font-semibold text-slate-900 dark:text-white mb-1">Revisa el contexto</h4>
                                            <p class="text-slate-600 dark:text-slate-300">Lee objetivos, periodo y criterios de evaluación antes de responder.</p>
                                        </div>
                                    </div>

                                    <div class="flex">
                                        <div class="flex-shrink-0 w-10 h-10 bg-indigo-600 dark:bg-indigo-500 text-white rounded-full flex items-center justify-center font-bold mr-4">3</div>
                                        <div class="flex-1 pt-1">
                                            <h4 class="font-semibold text-slate-900 dark:text-white mb-1">Evalúa</h4>
                                            <p class="text-slate-600 dark:text-slate-300 mb-2">Marca tu nivel de satisfacción o percepción según la escala disponible.</p>
                                            <ul class="text-sm text-slate-600 dark:text-slate-400 space-y-1 ml-4">
                                                <li>• Muy satisfecho</li>
                                                <li>• Satisfecho</li>
                                                <li>• Neutral</li>
                                                <li>• Insatisfecho</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="flex">
                                        <div class="flex-shrink-0 w-10 h-10 bg-emerald-600 dark:bg-emerald-500 text-white rounded-full flex items-center justify-center font-bold mr-4">✓</div>
                                        <div class="flex-1 pt-1">
                                            <h4 class="font-semibold text-slate-900 dark:text-white mb-1">Confirma y analiza</h4>
                                            <p class="text-slate-600 dark:text-slate-300">La respuesta queda registrada y permite generar reportes útiles para la universidad.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-4">Resultados esperados</h3>
                                <p class="text-slate-600 dark:text-slate-300 mb-4">
                                    Después de responder, la universidad puede observar tendencias y priorizar mejoras con datos reales:
                                </p>
                                <div class="bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg p-6">
                                    <div class="grid md:grid-cols-3 gap-4 text-center">
                                        <div>
                                            <div class="text-3xl font-bold text-indigo-600 dark:text-indigo-400 mb-1">📊</div>
                                            <div class="text-sm font-semibold text-slate-900 dark:text-white">Indicadores</div>
                                            <div class="text-xs text-slate-600 dark:text-slate-400 mt-1">Nivel de satisfacción por curso</div>
                                        </div>
                                        <div>
                                            <div class="text-3xl font-bold text-amber-600 dark:text-amber-400 mb-1">📈</div>
                                            <div class="text-sm font-semibold text-slate-900 dark:text-white">Tendencias</div>
                                            <div class="text-xs text-slate-600 dark:text-slate-400 mt-1">Cambio comportamental y mejora continua</div>
                                        </div>
                                        <div>
                                            <div class="text-3xl font-bold text-emerald-600 dark:text-emerald-400 mb-1">✅</div>
                                            <div class="text-sm font-semibold text-slate-900 dark:text-white">Acciones</div>
                                            <div class="text-xs text-slate-600 dark:text-slate-400 mt-1">Mejoras en docencia y servicios</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
