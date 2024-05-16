@vite(['resources/css/app.css', 'resources/js/app.js'])

<div class="max-w-3xl mx-auto">
     <div class="py-5 mt-10 border-2 border-dashed bg-white  rounded-lg">
          <div class="px-10 text-sm">
              <div class="flex justify-between">
                  <div>Name: <span class="font-bold">{{ $examinee->name }}</span></div>
                  <div>Email: <span class="font-bold">{{ $examinee->email }}</span></div>
              </div>
              <div class="flex justify-between">
                  <div>Grade Level: <span class="font-bold">Grade {{ $examinee->grade_level }}</span></div>
                  <div>Examination Date: <span class="font-bold">{{ $examinee->created_at->format('F j, Y') }}</span></div>
              </div>
          </div>
          <div class="flex gap-10 px-10 mt-4 justify-center">
               <div class="bg-gradient-to-bl from-30% from-blue-500 to-indigo-200 h-52 w-52 aspect-square rounded-full text-center flex flex-col gap-2 justify-center my-auto">
                    <div class="text-white font-bold">Average</div>
     
                    <h1 class="text-white font-extrabold text-6xl">
                         {{ round($examinee->scores->pluck('score')->sum() / $examinee->scores->pluck('total')->sum() * 100, 1) }}%
                    </h1>
     
                    <div class="text-white font-bold">
                         <span class="font-bold">{{ $examinee->scores->pluck('score')->sum() }}</span>
                         out of {{ $examinee->scores->pluck('total')->sum() }}
                    </div>
     
               </div>
               <div class="flex-1 flex flex-col">
                    @if ($examinee->grade_level === 11)
                         <div class="flex gap-4">
                              <h4 class="mt-auto">Strand:</h4>
                              <h1 class="text-4xl mt-2 font-bold">{{ $examinee->strandRecommendations->where('ranking', 1)->first()->strand->title }}</h1>
                         </div>
                    @elseif ($examinee->grade_level === 7)
                         <div class="flex gap-4">
                              <h4 class="mt-auto">Section:</h4>
                              <h1 class="text-4xl mt-2 font-bold">{{ $examinee->sectionPivot->section->letter }} - {{ $examinee->sectionPivot->section->description }}</h1>
                         </div>
                    @endif
                    @if($examinee->grade_level === 11)
                         <div class="flex gap-2">
                              <div>Description: </div>
                              <span class="font-bold">{{ $examinee->strandRecommendations->where('ranking', 1)->first()->strand->description }}</span>
                         </div>
                    @endif
     
                    <div class="flex-1 flex justify-between gap-2 mt-4">
                         <div class = 'bg-gradient-to-b from-30% from-yellow-400 to-yellow-200 h-36 w-full text-center flex flex-col gap-2 text-white justify-center rounded-xl'>
                              <h1 class="text-center text-sm">English</h1>
                              <h1 class="text-4xl font-bold">
                              {{ round($examinee->scores->where('category_id', 3)->first()->score / $examinee->scores->where('category_id', 3)->first()->total * 100, 1) }}%
                              </h1>
                              <h1 class="text-center text-sm"><span class="font-bold">{{ $examinee->scores->where('category_id', 3)->first()->score }}</span> out of {{ $examinee->scores->where('category_id', 3)->first()->total }}</h1>
                         </div>
                         <div class="bg-gradient-to-br from-10% from-purple-500 to-violet-300 h-36 w-full text-center flex flex-col gap-2 text-white justify-center rounded-xl">
                              <h1 class="text-center text-sm">Science</h1>
                              <h1 class="text-4xl font-bold">
                                   {{ round($examinee->scores->where('category_id', 2)->first()->score / $examinee->scores->where('category_id', 2)->first()->total * 100, 1) }}%
                              </h1>
                              <h1 class="text-center text-sm"><span class="font-bold">{{ $examinee->scores->where('category_id', 2)->first()->score }}</span> out of {{ $examinee->scores->where('category_id', 2)->first()->total }}</h1>
                         </div>
                         <div class="bg-gradient-to-br from-30% from-red-500 to-red-300 h-36 w-full text-center flex flex-col gap-2 text-white justify-center rounded-xl">
                              <h1 class="text-center text-sm">Mathematics</h1>
                              <h1 class="text-4xl font-bold">
                                   {{ round($examinee->scores->where('category_id', 1)->first()->score / $examinee->scores->where('category_id', 1)->first()->total * 100, 1) }}%
                              </h1>
                              <h1 class="text-center text-sm"><span class="font-bold">{{ $examinee->scores->where('category_id', 1)->first()->score }}</span> out of {{ $examinee->scores->where('category_id', 1)->first()->total }}</h1>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>