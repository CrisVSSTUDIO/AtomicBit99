<x-card-generic>
    <div class="py-14">
        <div class="max-w-screen-xl mx-auto px-4 md:px-8">
            <div class="max-w-xl mx-auto text-center">
                <h3 class="text-gray-800 text-3xl font-semibold sm:text-4xl">
                    Tecnologies used
                </h3>
                <p class="text-gray-600 mt-3">
                    The great tech stack that powers {{config('app.name', 'Laravel') }}!
                </p>
            </div>
            <div class="mt-12 flex justify-center">
                <ul class="inline-grid grid-cols-2 gap-x-10 gap-y-6 md:gap-x-16 md:grid-cols-3 lg:grid-cols-4">

                    <li>
                        <Link away href="https://laravel.com/">Laravel</Link>
                    </li>

                    <li>
                        <Link away href="https://splade.dev/">Laravel Splade</Link>

                    </li>

                    <li>

                        <Link away href="https://vuejs.org/">Vue js</Link>

                    </li>

                    <li>
                        <Link away href="https://spatie.be/docs/laravel-permission/v6/introduction">Spatie (Laravel)
                        </Link>

                    </li>

                    <li>
                        <Link away href="https://php-ml.readthedocs.io/en/latest/">PHP-ML</Link>

                    </li>

                    <li>

                        <Link away href=" https://modelviewer.dev/">model-viewer</Link>

                    </li>
                    <li>
                        <Link away href="https://apexcharts.com/docs/vue-charts/">Apex charts</Link>
                    </li>

                    <li>
                        <Link away href="https://particles.js.org/">tsParticles</Link>
                    </li>

                    <li>
                        <Link away href=" https://pqina.nl/filepond/">FilePond</Link>
                    </li>
                    <li>
                      <Link away href="https://floatui.com/">FloatUI</Link>
                  </li>
                  <li>
                    <Link away href="https://icons.getbootstrap.com/">Bootstrap Icons</Link>

                  </li>
                  <li>
                    <Link away href="https://www.tensorflow.org/js?hl=en">Tensorflow (js)</Link>

                  </li>

                </ul>
            </div>
        </div>
    </div>
</x-card-generic>
