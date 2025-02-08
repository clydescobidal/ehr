

<script lang="ts">
    import dayjs from 'dayjs'

    let currentDateTime = [];
    const getCurrentTime = () =>{
        currentDateTime = dayjs().format('dddd|hh:mm:ss|A|MMM D, YYYY').split('|')
        
        setTimeout(getCurrentTime, 1000)
    }
    getCurrentTime()
</script>


<div class="leading-tight text-left flex items-center">
    <div class="font-semibold text-lg">{currentDateTime[0]}</div>
    <div>
        <span class="w-[65px] inline-block text-left">{currentDateTime[1]}</span>
        {currentDateTime[2]}
    </div>
    <div class="text-sm opacity-50">{currentDateTime[3]}</div>
</div>