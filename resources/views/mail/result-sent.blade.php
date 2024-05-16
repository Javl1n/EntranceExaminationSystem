{{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
{{-- <script src="https://cdn.tailwindcss.com"></script> --}}
<h1>Dear {{ $examinee->name }}</h1>
<br>
<p>Greetings from St. Lorenzo School of Polomolok, Inc.! We would like to extend our heartfelt thanks for choosing our institution for your academic fourney. Your decision to take the entrance examination with us is greatly appreciated.</p>
<br>
<p>We look forward to welcoming you to our school community!</p>
<br>
<p>Warm regards</p>
<br>
<p>St. Lorenzo School of Polomolok, Inc.</p>
<br>
<br>
<p>Screen shot and print the qualifying slip below: </p>

<style>

</style>

<div style="max-width: 48rem; margin: 40px auto">
     <div style="padding: 1.25rem;  border-radius: 0.5rem; border-width: 2px;  border-style: dashed; background-color: #ffffff; 
     ">
          <div  style="padding-left: 2.5rem; padding-right: 2.5rem;  font-size: 0.875rem; line-height: 1.25rem;">
              <div style="display: flex; justify-content: space-between; ">
                  <div>Name: <span style="font-weight: 700; ">{{ $examinee->name }}</span></div>
              </div>
              <div style="display: flex; justify-content: space-between; ">
                    <div>Email: <span style="font-weight: 700; ">{{ $examinee->email }}</span></div>
              </div>
          </div>
          <div style="display: flex; margin: 20px 10px">
               <div style="aspect-ratio: 1 / 1; gap: 0.5rem; border-radius: 20px; width: 13rem; height: 13rem; text-align: center; background-color: #C7D2FE; margin-right: 20px;">
                    <div style="margin-top: 40px">
                         <div style="font-weight: 700;">Average</div>
                         
                         <div>
                              <h1 style="text-align: center; font-size: 2rem/*;
                              " class="text-5xl">
                                   {{ round($examinee->scores->pluck('score')->sum() / $examinee->scores->pluck('total')->sum() * 100, 1) }}%
                              </h1>
                         </div>
                         <div style="">
                              <span style="font-weight: 700; ">{{ $examinee->scores->pluck('score')->sum() }}</span>
                              out of {{ $examinee->scores->pluck('total')->sum() }}
                         </div>
                    </div>
     
               </div>
               <div style="flex-1 flex flex-col">
                    @if ($examinee->grade_level === 11)
                         <div style="flex gap-4">
                              <h4 style="mt-auto">Strand:</h4>
                              <h1 style="text-4xl mt-2 font-bold">{{ $examinee->strandRecommendations->where('ranking', 1)->first()->strand->title }}</h1>
                         </div>
                    @elseif ($examinee->grade_level === 7)
                         <div style="flex gap-4">
                              <h4 style="mt-auto">Section:</h4>
                              <h1 style="text-4xl mt-2 font-bold">{{ $examinee->sectionPivot->section->letter }} - {{ $examinee->sectionPivot->section->description }}</h1>
                         </div>
                    @endif
                    @if($examinee->grade_level === 11)
                         <div style="flex gap-2">
                              <div>Description: </div>
                              <span style="font-weight: 700; ">{{ $examinee->strandRecommendations->where('ranking', 1)->first()->strand->description }}</span>
                         </div>
                    @endif
                    <div>Grade Level: <span style="font-weight: 700; ">Grade {{ $examinee->grade_level }}</span></div>
                    <div>Examination Date: <span style="font-weight: 700; ">{{ $examinee->created_at->format('F j, Y') }}</span></div>
               </div>
          </div>
     </div>
</div>
{{-- <div style="margin-top: 2.5rem; margin-bottom: 2.5rem; max-width: 48rem; ">
     <div style="padding-top: 1.25rem; padding-bottom: 1.25rem; margin-top: 2.5rem; border-radius: 0.5rem; border-width: 2px;  border-style: dashed; background-color: #ffffff; 
     " class="py-5 mt-10 border-2 border-dashed bg-white  rounded-lg">
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
</div> --}}