<?php

use function Livewire\Volt\{state, layout};

layout('layouts.app');

title(fn() => $this->examinee . ' - SLSPI Entrance Exam');

state([
    'examinee'
]);

?>

<div>
    //
</div>
