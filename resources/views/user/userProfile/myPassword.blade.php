<x-userHeader />
<div class="bg-white md:self-start mb-80 self-center  p-5 w-auto md:w-8/12">
    <h3 class="font-bold text-gray-800">My Password</h3>
    <h6 class="font-light text-gray-500 text-sm">Secure my password</h6>
    <hr class="mt-4 mb-8">
    <div class="w-full justify-evenly flex items-start flex-row ">
        <div class="flex flex-col md:text-base text-xs gap-2">
            <label for="password" class="h-8">New Password</label>
            <label for="" class="h-8">Confirm New Password</label>
        </div>
        <div>
            <form action="" class="flex flex-col gap-2 ">
                @csrf
                <input type="password" name="newPassword" class="md:text-base text-xs h-8 w-full border-gray-300">
                <input type="password" name="cnfmPassword" class="md:text-base text-xs h-8 w-full border-gray-300"> 
                <button class="md:text-base text-xs bg-orange-700 text-white px-2 py-1 md:px-4 md:py-2 rounded-sm w-full">Submit</button>
            </form>
        </div>
        
    </div>
   
</div>
<x-userFooter />