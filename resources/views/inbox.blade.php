<x-app-layout>
    <style>
        .inbox-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            min-height: 100vh;
            border-left: 1px solid #dbdbdb;
            border-right: 1px solid #dbdbdb;
        }
        
        .inbox-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 16px;
            border-bottom: 1px solid #dbdbdb;
        }
        
        .inbox-header-title {
            font-size: 16px;
            font-weight: 600;
        }
        
        .inbox-header-icons {
            display: flex;
            gap: 16px;
        }
        
        .inbox-header-icons i {
            font-size: 20px;
            cursor: pointer;
        }
        
        .inbox-item {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            border-bottom: 1px solid #efefef;
            cursor: pointer;
        }
        
        .inbox-item:hover {
            background-color: #fafafa;
        }
        
        .inbox-avatar {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: #efefef;
            margin-right: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #999;
        }
        
        .inbox-content {
            flex: 1;
        }
        
        .inbox-name {
            font-weight: 600;
            margin-bottom: 2px;
        }
        
        .inbox-message {
            color: #8e8e8e;
            font-size: 14px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            max-width: 300px;
        }
        
        .inbox-time {
            color: #8e8e8e;
            font-size: 12px;
            margin-top: 4px;
        }
        
        .inbox-section-title {
            padding: 16px 16px 8px;
            font-size: 14px;
            font-weight: 600;
            color: #262626;
        }
        
        .inbox-divider {
            height: 8px;
            background-color: #fafafa;
            border-top: 1px solid #dbdbdb;
            border-bottom: 1px solid #dbdbdb;
        }
        
        .inbox-badge {
            background-color: #efefef;
            color: #262626;
            font-size: 12px;
            padding: 2px 8px;
            border-radius: 10px;
            margin-left: 8px;
        }
    </style>

    <div class="inbox-container">
        <div class="inbox-header">
            <div class="inbox-header-title">{{ auth()->user()->name }}</div>
            <div class="inbox-header-icons">
                <i class="fa-regular fa-video"></i>
                <i class="fa-regular fa-pen-to-square"></i>
            </div>
        </div>
        
        <div class="inbox-section-title">Messages</div>
        
        <div class="inbox-item">
            <div class="inbox-avatar"><i class="fa-regular fa-bell"></i></div>
            <div class="inbox-content">
                <div class="inbox-name">System Notifications</div>
                <div class="inbox-message">Welcome to {{ config('app.name') }}!</div>
            </div>
        </div>
        
        <div class="inbox-item">
            <div class="inbox-avatar"><i class="fa-regular fa-user"></i></div>
            <div class="inbox-content">
                <div class="inbox-name">Support Team</div>
                <div class="inbox-message">How can we help you today?</div>
            </div>
        </div>
        
        <div class="inbox-divider"></div>
        
        <div class="inbox-section-title">Recent Activity <span class="inbox-badge">2</span></div>
        
        <div class="inbox-item">
            <div class="inbox-avatar"><i class="fa-regular fa-shopping-cart"></i></div>
            <div class="inbox-content">
                <div class="inbox-message">Your order has been processed</div>
                <div class="inbox-time">2h ago</div>
            </div>
        </div>
        
        <div class="inbox-item">
            <div class="inbox-avatar"><i class="fa-regular fa-heart"></i></div>
            <div class="inbox-content">
                <div class="inbox-message">Someone liked your asset</div>
                <div class="inbox-time">5h ago</div>
            </div>
        </div>
        
        <div class="inbox-divider"></div>
        
        <div class="inbox-item">
            <div class="inbox-avatar"><i class="fa-regular fa-user"></i></div>
            <div class="inbox-content">
                <div class="inbox-name">Admin</div>
                <div class="inbox-message">Your asset has been approved</div>
                <div class="inbox-time">1d ago</div>
            </div>
        </div>
    </div>
</x-app-layout>