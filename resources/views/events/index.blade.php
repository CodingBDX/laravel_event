<x-app-layout>









    <a class="relative block p-8 overflow-hidden border border-gray-100 rounded-lg" href="">
        <span class="absolute inset-x-0 bottom-0 h-2  bg-gradient-to-r from-green-300 via-blue-500 to-purple-600"></span>
        @foreach ($events as $event)
            <div class="justify-between sm:flex {{ $event->premium ? 'bg-yellow-500' : '' }}">
                <div>
                    <h5 class="text-xl font-bold text-gray-900">
                        {{ $event->title }}

                    </h5>
                    <p class="mt-1 text-xs font-medium text-gray-600"> {{ $event->user->name }}</p>
                </div>

                <div class="flex-shrink-0 hidden ml-3 sm:block">
                    <img class="object-cover w-16 h-16 rounded-lg shadow-sm"
                        src="https://www.hyperui.dev/photos/man-5.jpeg" alt="" />
                </div>
            </div>

            <div class="mt-4 sm:pr-8">
                <p class="text-sm text-gray-500">
                    {{ $event->content }}

                </p>
            </div>

            <dl class="flex mt-6">
                <div class="flex flex-col-reverse">
                    <dt class="text-sm font-medium text-gray-600">Published</dt>
                    <dd class="text-xs text-gray-500"> {{ $event->starts_at->format('M') }}
                        {{ $event->starts_at->format('d') }}
                    </dd>
                </div>

                <div class="flex flex-col-reverse ml-3 sm:ml-6">
                    <dt class="text-sm font-medium text-gray-600"> {{ $event->ends_at->format('M') }}
                        {{ $event->ends_at->format('d') }}
                    </dt>
                    <dd class="text-xs text-gray-500">
                        @foreach ($event->tags as $tag)
                            {{ $tag->name }}{{ !$loop->last ? ',' : '' }}
                        @endforeach
                    </dd>
                </div>

            </dl>
        @endforeach
    </a>

</x-app-layout>
