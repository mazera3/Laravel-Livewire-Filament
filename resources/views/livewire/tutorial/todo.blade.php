<div style="font-size: 1000%; text-align: center; border: 10px solid blue; margin: 1px 300px 1px 300px;">
    <input type="text" wire:model="todo" placeholder="Todo..." style="font-size: 30%;" /> 
 
    <button style="font-size: 30%; background-color: indigo;" wire:click="add">Add</button>
 
    <ul>
        @foreach ($todos as $todo)
            <li style="font-size: 20%;">{{ $todo }}</li>
        @endforeach
    </ul>
    <a style="font-size: 30%;" href="http://localhost:8000">voltar</a>
</div>
