  <!--  BEGIN SIDEBAR  -->
  <div class="sidebar-wrapper sidebar-theme">
            
    <nav id="sidebar">
        <div class="profile-info">
            <figure class="user-cover-image"></figure>
            <div class="user-info">
                <img src="{{ asset('slamcoin.svg')}}" alt="avatar">
                <h6 class="">Hussein Armani</h6>
                <p class="">SLAM Owner</p>
            </div>
        </div>

        <div class="shadow-bottom"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample">

            <li class="menu {{($active=='user')?'active':''}}">
                <a href="{{ route('admin.index')}}" aria-expanded="{{($active=='user')?'true':''}}" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        <span>User</span>
                    </div>
                </a>
            </li>
   
            <li class="menu {{($active=='transaction')?'active':''}}">
                <a href="{{ route('admin.transaction')}}" aria-expanded="{{($active=='transaction')?'true':''}}" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search toggle-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        <span>Transactions</span>
                    </div>
                </a>
            </li>

            <li class="menu {{($active=='affiliation')?'active':''}}">
                <a href="{{ route('admin.affiliation')}}" aria-expanded="{{($active=='affiliation')?'true':''}}" class="dropdown-toggle">
                    <div class="">
                        <!-- <img class="feather feather-search toggle-share" src="{{asset('assets/img/hand-shake.png')}}" width="24" /> -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search toggle-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        <span>Affiliations</span>
                    </div>
                </a>
            </li>
            
            <li class="menu {{($active=='affiliationManage')?'active':''}}">
                <a href="{{ route('admin.affiliation.manage')}}" aria-expanded="{{($active=='affiliationManage')?'true':''}}" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search toggle-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        <span>Manage Affiliation</span>
                    </div>
                 </a>
            </li>
            
            <li class="menu {{($active=='cryptoHolders')?'active':''}}">
                <a href="{{ route('admin.cryptoHolders')}}" aria-expanded="{{($active=='cryptoHolders')?'true':''}}" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search toggle-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        <span>Crypto Holders(BNB)</span>
                    </div>
                 </a>
            </li>

            <li class="menu {{($active=='cryptoHoldersEth')?'active':''}}">
                <a href="{{ route('admin.cryptoHolders.eth')}}" aria-expanded="{{($active=='cryptoHoldersEth')?'true':''}}" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search toggle-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        <span>Crypto Holders(Eth)</span>
                    </div>
                 </a>
            </li>

            <li class="menu {{($active=='historyRecord')?'active':''}}">
                <a href="{{ route('admin.historyRecord')}}" aria-expanded="{{($active=='historyRecord')?'true':''}}" class="dropdown-toggle">
                    <div class="">
                        <!-- <img class="feather feather-search toggle-share" src="{{asset('assets/img/hand-shake.png')}}" width="24" /> -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search toggle-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        <span>History and Record</span>
                    </div>
                </a>
            </li>

            <li class="menu {{($active=='bulkemail')?'active':''}}">
                <a href="{{ route('admin.bulkemail')}}" aria-expanded="{{($active=='bulkemail')?'true':''}}" class="dropdown-toggle">
                    <div class="">
                        <!-- <img class="feather feather-search toggle-share" src="{{asset('assets/img/hand-shake.png')}}" width="24" /> -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search toggle-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        <span>Bulk Email</span>
                    </div>
                </a>
            </li>

            <li class="menu {{($active=='setting')?'active':''}}">
                <a href="{{ route('admin.setting')}}" aria-expanded="{{($active=='setting')?'true':''}}" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                        <span>Setting</span>
                    </div>
                </a>
            </li>
                     
        </ul>
        
    </nav>
   
</div>
<!--  END SIDEBAR  -->