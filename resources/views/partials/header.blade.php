<header
	class="flex px-10 lg:px-primary justify-between flex-nowrap text-black py-4 text-xl border-b border-black/30 dark:text-white dark:bg-slate-800">
	<div class="font-semibold">
		<a href="{{ route('home') }}">
			FreeTest
		</a>
	</div>
	<nav>
		<ul class="flex items-center ml-auto gap-x-4">
			<li>
				<a href="{{ route('about') }}">About</a>
			</li>
			<li>
				<a href="{{ route('exams.index') }}">Exams</a>
			</li>
			<li>
				<a href="{{ route('posts.index') }}">Posts</a>
			</li>
		</ul>
	</nav>
	<div class="history">
		<a href="{{ route('history') }}">History</a>
	</div>
</header>
