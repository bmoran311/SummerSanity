<x-app-layout>

<div class="mb-8">
    <div class="bg-yellow-50 text-center border border-yellow-200 p-4 shadow-lg shadow-slate-200 max-w-5xl mx-auto" role="alert">
        <p class="text-sm leading-5 text-yellow-700">
        <b>Blog posts</b> on a legal website serve as informative and engaging content that educates visitors, builds trust, and showcases the firm's expertise.<br>
        Each blog post should address a specific question, concern, or topic relevant to the firm's target audience while maintaining professionalism and clarity.
        </p>
    </div>
</div>

<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-title-md2 font-bold text-black dark:text-white">
    Blog Posts
    </h2>
    <nav>
        <ol class="flex items-center gap-2">
            <li>
                <a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a>
            </li>
            <li class="font-medium text-primary">Blog Posts</li>
        </ol>
    </nav>
</div>

<section class="flex justify-end mb-4">
    <x-create-button href="{{ route('blog_post.create') }}">Add Blog Post</x-create-button>
</section>

<div class="flex flex-col gap-10">
    <div class="rounded-sm border border-stroke bg-white px-5 pb-2.5 pt-6 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto summer-sanity-table sortable">
                <thead>
                    <tr class="bg-gray-2 text-left dark:bg-meta-4">
                        <th class="min-w-[220px]  xl:pl-11">
                            Title
                        </th>
                        <th class="min-w-[150px]">
                            Publication Date
                        </th> 
						<th class="min-w-[150px]">
                            Slug
                        </th>
                        <th class="min-w-[150px]">
                            Tags
                        </th>
                        <th class="no-sort">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($blog_posts as $blog_post)
                        <tr>
                            <td class="border-b border-[#eee] px-4 py-5 pl-9 dark:border-strokedark xl:pl-11">
                                <h5 class="font-medium text-black dark:text-white">{{ $blog_post->title }}</h5>
                            </td>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                <p class="text-black dark:text-white">{{ $blog_post->published_date }}</p>
                            </td> 
							<td class="border-b border-[#eee] px-4 py-5 pl-9 dark:border-strokedark xl:pl-11">
                                <h5 class="font-medium text-black dark:text-white">{{ $blog_post->slug }}</h5>
                            </td>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                <p class="text-black dark:text-white">{{ $blog_post->tags }}</p>
                            </td>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                <div class="flex items-center space-x-3.5">
                                    <button class="hover:text-primary">
                                        <a href="{{ route('blog_post.edit', ['blog_post' => $blog_post]) }}"><x-icon-view /></a>
                                    </button>
                                    <form action="{{route('blog_post.destroy', ['blog_post' => $blog_post])}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this blog post?')">
                                        @method('DELETE')
                                        @csrf
                                        <button class="hover:text-primary">
                                            <x-icon-delete />
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</x-app-layout>
