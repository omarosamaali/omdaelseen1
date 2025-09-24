@extends('layouts.mobile')

@section('title', 'عمدة الصين | China Omda')

@section('content')
<style>
    .tab-details-content {
        text-align: center;
    }

    .quiz-link {
        box-shadow: 0px 1px 2px 0px rgb(58 58 58 / 62%), 0px 1px 3px 0px rgb(58 58 58 / 36%);
    }

    .fly-img {
        text-align: center;
        margin: auto;
        width: 142px;
        position: relative;
        top: 15px;
        right: 0px;
    }

    .container--features {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0px 15px;
        margin-top: 20px;
        margin: 0;
    }

    .container--features div {
        display: flex;
        align-items: center;
        margin-top: 10px;
    }

    .container--features div img {
        width: 60px;
        height: 60px;
    }

    .img-places {
        margin: auto;
        width: 95%;
        margin-top: 74px;
        height: 166px;
    }

    .image-logo {
        margin-top: 10px !important;
        width: 150px;
        text-align: center;
        display: flex;
        justify-content: center;
        margin: auto;
    }

    .search--icon {
        left: 19px;
        top: 27px;
    }

    .continaer--title {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 13px;
    }

    .show--all {
        font-size: 14px;
        color: gray;
    }

    .categories {
        font-weight: bold;
        font-size: 18px;
        color: white;
    }

    /* Slider Styles */
    .slider-container {
        margin: 20px 10px;
        overflow: hidden;
    }

    .slider {
        display: flex;
        gap: 15px;
        overflow-x: auto;
        scroll-behavior: smooth;
        padding: 10px 5px;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    .slider::-webkit-scrollbar {
        display: none;
    }

    .place-card {
        min-width: 200px;
        height: 250px;
        position: relative;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
        opacity: 0;
        animation: fadeInUp 0.6s ease forwards;
    }

    .place-card:hover {
        transform: translateY(-5px);
    }

    .place-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .place-card:nth-child(1) {
        animation-delay: 0.1s;
    }

    .place-card:nth-child(2) {
        animation-delay: 0.2s;
    }

    .place-card:nth-child(3) {
        animation-delay: 0.3s;
    }

    .place-card:nth-child(4) {
        animation-delay: 0.4s;
    }

    .place-card:nth-child(5) {
        animation-delay: 0.5s;
    }

    .place-card:nth-child(6) {
        animation-delay: 0.6s;
    }

    .heart-icon {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 50%;
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .heart-icon:hover {
        background: rgba(255, 181, 49, 0.9);
        transform: scale(1.1);
    }

    .heart-icon.liked {
        background: rgba(255, 181, 49, 0.9);
        color: #ff6b6b;
    }

    .category-tag {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(255, 181, 49, 0.95);
        padding: 5px 8px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        font-weight: bold;
        color: white;
    }

    .category-tag img {
        width: 16px;
        height: 16px;
        object-fit: cover;
        border-radius: 3px;
    }

    .place-name {
        position: absolute;
        bottom: 50px;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
        color: white;
        padding: 20px 15px 10px;
        font-size: 16px;
        font-weight: bold;
        text-align: center;
    }

    .explore-btn {
        position: absolute;
        bottom: 10px;
        left: 50%;
        transform: translateX(-50%);
        background: maroon;
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(255, 181, 49, 0.3);
    }

    .explore-btn:hover {
        background: #ffa500;
        transform: translateX(-50%) translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 181, 49, 0.4);
    }

    .popular-card {
        border: 2px solid maroon;
        box-shadow: 0 6px 20px rgba(255, 181, 49, 0.2);
    }

    .popular-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 25px rgba(255, 181, 49, 0.3);
    }

    .popular-tag {
        background: linear-gradient(45deg, maroon, #ffa500);
        color: white;
        font-weight: bold;
    }

    .popular-btn {
        background: linear-gradient(45deg, maroon, #ffa500);
        color: white;
        font-weight: bold;
    }

    .popular-btn:hover {
        background: linear-gradient(45deg, #ffa500, #ff8c00);
        transform: translateX(-50%) translateY(-3px);
        box-shadow: 0 6px 15px rgba(255, 181, 49, 0.5);
    }

    .latest-card {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 181, 49, 0.05));
        backdrop-filter: blur(10px);
    }

    .latest-card .category-tag {
        background: rgba(74, 45, 11, 0.9);
        color: maroon;
    }

    .latest-card .explore-btn {
        background: white;
        color: maroon;
        border: 1px solid maroon;
    }

    .latest-card .explore-btn:hover {
        background: maroon;
        color: white;
        transform: translateX(-50%) translateY(-2px);
    }

    .slider-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255, 181, 49, 0.9);
        color: white;
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        transition: all 0.3s ease;
        z-index: 10;
    }

    .slider-nav:hover {
        background: #ffa500;
        transform: translateY(-50%) scale(1.1);
    }

    .slider-nav.prev {
        left: -20px;
    }

    .slider-nav.next {
        right: -20px;
    }

    .slider-container {
        position: relative;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .overall-rating {
        background: linear-gradient(135deg, maroon 0%, #ffa500 100%);
        color: white;
        padding: 20px;
        border-radius: 15px;
        text-align: center;
        margin-bottom: 25px;
        box-shadow: 0 8px 25px rgba(255, 181, 49, 0.3);
    }

    .rating-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .rating-summary {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .average-rating {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }

    .avg-number {
        font-size: 48px;
        font-weight: bold;
        line-height: 1;
    }

    .avg-stars {
        display: flex;
        gap: 3px;
        font-size: 20px;
    }

    .avg-stars i {
        color: rgba(255, 255, 255, 0.9);
    }

    .total-reviews {
        font-size: 14px;
        opacity: 0.9;
    }

    .add-rating-section {
        margin-bottom: 30px;
    }

    .add-rating-title {
        font-size: 16px;
        font-weight: bold;
        color: white;
        margin-bottom: 15px;
        text-align: center;
    }

    .reviews-section {
        margin-top: 30px;
    }

    .reviews-title {
        font-size: 18px;
        font-weight: bold;
        color: white;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .reviews-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
        overflow-y: auto;
        padding-right: 5px;
    }

    .reviews-list::-webkit-scrollbar {
        width: 6px;
    }

    .reviews-list::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }

    .reviews-list::-webkit-scrollbar-thumb {
        background: maroon;
        border-radius: 3px;
    }

    .review-item {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 12px;
        padding: 15px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .review-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .review-item.new-review {
        border-color: maroon;
        background: linear-gradient(135deg, rgba(255, 181, 49, 0.05) 0%, rgba(255, 165, 0, 0.05) 100%);
        animation: newReviewAnimation 1s ease;
    }

    @keyframes newReviewAnimation {
        0% {
            opacity: 0;
            transform: translateY(20px) scale(0.95);
        }

        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .review-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .reviewer-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .reviewer-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, maroon, #ffa500);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 14px;
    }

    .reviewer-name {
        font-weight: bold;
        color: white;
        font-size: 14px;
    }

    .review-rating {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .review-stars {
        display: flex;
        gap: 2px;
        font-size: 16px;
    }

    .review-stars .fa-solid.fa-star {
        color: maroon;
    }

    .review-stars .fa-star {
        color: #ddd;
    }

    .review-date {
        font-size: 12px;
        color: #666;
        margin-right: 5px;
    }

    .review-comment {
        color: #555;
        line-height: 1.5;
        margin-top: 8px;
        font-size: 14px;
    }

    .no-reviews {
        text-align: center;
        color: #666;
        font-style: italic;
        padding: 40px 20px;
        background: #f8f9fa;
        border-radius: 12px;
        border: 2px dashed #ddd;
    }

    .rating-container {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .rating-boxes {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        flex-wrap: wrap;
    }

    .rating-box {
        flex: 1;
        width: 41px;
        flex-wrap: nowrap;
        height: 71px;
        background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: row-reverse;
        gap: 5px;
        height: 41px;
    }

    .rating-box::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, transparent 0%, rgba(255, 181, 49, 0.05) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .rating-box:hover {
        border-color: maroon;
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(255, 181, 49, 0.2);
    }

    .rating-box:hover::before {
        opacity: 1;
    }

    .rating-box.selected {
        background: linear-gradient(135deg, maroon 0%, #ffa500 100%);
        border-color: #ff8c00;
        color: white;
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(255, 181, 49, 0.4);
    }

    .rating-star {
        font-size: 24px;
        color: maroon;
        margin-bottom: 5px;
        transition: all 0.3s ease;
    }

    .rating-box.selected .rating-star {
        color: white;
        transform: scale(1.2);
    }

    .rating-number {
        font-size: 14px;
        font-weight: bold;
        color: white;
        transition: color 0.3s ease;
    }

    .rating-box.selected .rating-number {
        color: white;
    }

    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(5px);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 1000;
        animation: fadeIn 0.3s ease;
    }

    .modal-overlay.show {
        display: flex;
    }

    .modal {
        background: white;
        border-radius: 20px;
        padding: 30px;
        width: 90%;
        max-width: 400px;
        position: relative;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        transform: scale(0.7);
        opacity: 0;
        transition: all 0.3s ease;
    }

    .modal-overlay.show .modal {
        transform: scale(1);
        opacity: 1;
    }

    .modal-close {
        position: absolute;
        top: 15px;
        left: 15px;
        background: none;
        border: none;
        font-size: 24px;
        color: #999;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .modal-close:hover {
        color: #ff6b6b;
    }

    .modal-title {
        font-size: 20px;
        font-weight: bold;
        color: white;
        text-align: center;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .modal-rating-display {
        display: flex;
        justify-content: center;
        gap: 5px;
        direction: rtl;
        margin-bottom: 20px;
    }

    .modal-star {
        font-size: 28px;
        color: #ddd;
        transition: color 0.3s ease;
    }

    .modal-star.filled {
        color: maroon;
        animation: starPulse 0.5s ease;
    }

    @keyframes starPulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.2);
        }

        100% {
            transform: scale(1);
        }
    }

    .modal-comment {
        width: 100%;
        min-height: 100px;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        padding: 15px;
        font-size: 16px;
        resize: vertical;
        transition: border-color 0.3s ease;
        box-sizing: border-box;
        font-family: inherit;
        direction: rtl;
    }

    .modal-comment:focus {
        outline: none;
        border-color: maroon;
        box-shadow: 0 0 0 3px rgba(255, 181, 49, 0.1);
    }

    .modal-actions {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    .modal-button {
        flex: 1;
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .confirm-button {
        background: linear-gradient(135deg, maroon 0%, #ffa500 100%);
        color: white;
    }

    .confirm-button:hover {
        background: linear-gradient(135deg, #ffa500 0%, #ff8c00 100%);
        transform: translateY(-2px);

        box-shadow: 0 8px 20px rgba(255 181 49 / 50%);
    }

    .image-modal {
        border-radius: 15px;
        width: 90%;
        max-width: 800px;
        position: relative;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        transform: scale(0.7);
        opacity: 0;
        transition: all 0.3s ease;
    }

    .modal-overlay.show .image-modal {
        transform: scale(1);
        opacity: 1;
    }

    .image-modal img {
        width: 100%;
        height: auto;
        max-height: 80vh;
        object-fit: contain;
        border-radius: 10px;
    }

    .gallery-images {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .gallery-images img {
        width: 48%;
        height: 200px;
        margin-bottom: 10px;
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    .gallery-images img:hover {
        transform: scale(1.05);
    }

    body {
        overflow-x: hidden;
    }

    .container {
        min-height: 100vh;
        position: relative;
        overflow: hidden;
        padding-bottom: 8px;
    }

    .container.dark {
        color: white;
        background: black;
    }

    .header-container {
        display: flex;
        justify-content: start;
        align-items: center;
        position: relative;
        z-index: 10;
        top: -20px;
        padding-bottom: 10px;
        padding-top: 20px;
        position: fixed;
        width: 100%;
    }

    .header-container img {
        height: 68px;
    }

    .logo-register {
        position: absolute;
        text-align: center;
        margin: auto;
        justify-content: center;
        display: flex;
        left: 30%;
        right: 50%;
        min-width: 150px;
    }

    .profile-link {
        background: white;
        padding: 8px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 20px;
        position: absolute;
        left: 20px;
        width: 36px;
        height: 36px;
    }

    .profile-link.dark {
        background: #1a1a1a;
    }

    .heart-container {
        position: relative;
        top: 47px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .heart-icon-main {
        position: relative;
        top: 13px;
        text-align: center;
        padding-top: 9px;
        left: 20px;
        font-size: 30px;
    }

    .container--features {
        margin-top: 50px;
        direction: rtl;
    }

    .main-image-container {
        display: flex;
        gap: 10px;
        justify-content: center;
    }

    .main-image-container div {
        width: 100%;
    }

    .main-image {
        width: 100%;
        height: 250px;
    }

    .place-name-ar,
    .place-name-en,
    .place-name-cn {
        display: flex;
        justify-content: end;
        padding: 10px;
        max-height: 72px;
        align-items: center;
    }

    .place-name-ar svg,
    .place-name-en svg,
    .place-name-cn svg {
        width: 39px;
        margin-left: 10px;
    }

    .tabs-container {
        direction: rtl;
    }

    .tab-buttons {
        display: flex;
        justify-content: center;
    }

    .tab-button {
        padding: 10px 16px;
        border: none;
        background-color: #000000;
        color: white;
        width: 100%;
        font-weight: bold;
        cursor: pointer;
        flex-wrap: nowrap;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .tab-button.active {
        background-color: maroon;
    }

    .tab-button.details {
        /* border-radius: 0 8px 8px 0; */
    }

    .tab-button.rating {
        /* border-radius: 8px 0 0 8px; */
    }

    .tab-content {
        padding: 20px;
        direction: rtl;
        border-radius: 0 0 8px 8px;
        margin-top: 10px;
    }

    .tab-content#tab1 {
        display: none;
    }

    .tab-content#tab2 {
        display: none;
    }

    .overall-rating {
        display: none;
    }

    .tab-details-content {
        display: flex;
        /* align-items: center; */
        gap: 10px;
        /* border-bottom: 1px solid #eee; */
        padding: 15px 0px;
    }

    .tab-details-content img {
        border-radius: 50%;
        width: 70px;
        height: 70px;
    }

    .tab-details-content p {
        /* border-bottom: 1px solid #eee; */
        padding: 15px 0;
    }

    .tab-details-link {
        /* border-bottom: 1px solid #eee; */
        margin: 15px 0;
        background-color: green;
        padding: 10px;
        border-radius: 8px;
        color: white;
        text-align: center;
    }

    @keyframes shake {

        0%,
        100% {
            transform: translateX(0);
        }

        25% {
            transform: translateX(-5px);
        }

        75% {
            transform: translateX(5px);
        }
    }

    #badgeModal {
        display: block;
        position: absolute;
        z-index: 9;
        background: white;
        padding: 3px;
        border-radius: 5px;
        top: -37px;
        width: max-content;
    }

    .tab-details-content-headpone {
        color: white;
        background: #000000;
        width: 26px;
        height: 26px;
        text-align: center;
        align-items: center;
        justify-content: center;
        display: flex;
        border-radius: 3px;
        font-size: 12px;
    }

    .fa-location-dot {
        margin-left: 5px;
    }

    .quiz-link {
        box-shadow: 0px 1px 15px 0px rgb(91 82 82 / 63%);
    }

    .fa.fa-x {
        color: #000;
        padding: 5px;
        border-radius: 3px;
        background: #ffffff9c;
    }

    .success-message {
        padding: 4px;
        text-align: center;
        border-radius: 5px;
        background: #4fb54f1f;
        color: green;
    }

    .report-button {
        background: red;
        color: white;
        border-radius: 6px;
        padding: 3px 8px;
        margin-top: 7px;
    }

    .tab-details-content {
        min-width: 132px;
    }

    .fly-img {
        text-align: center;
        margin: auto;
        width: 100%;
        margin-top: 30px;
        border-radius: 15px;
        padding-left: 13px;
        padding-right: 13px;
        top: 12px;
        width: 172px;
    }

    body {
        position: relative !important;
    }


    .quiz-link {
        box-shadow: 0px 1px 15px 0px rgb(91 82 82 / 63%);
    }

    .fly-img-order {
        text-align: center;
        margin: auto;
        width: 142px;
        position: relative;
        top: 29px;
        right: 0px;
        border-radius: 12px;
        width: 100%;
    }

    #pleaserotate-graphic,
    #pleaserotate-message {
        margin: auto !important;
        font-family: "Cairo", sans-serif !important;
    }

    #pleaserotate-message small {
        display: none !important;
    }

    .sub-category {
        position: absolute;
        top: 11px;
        left: -63px;
        background: maroon;
        color: white;
        rotate: -39deg;
        z-index: 9999999999999999999999999999;
        padding: 13px;
        width: 150px;
        font-size: 12px;
        text-align: center;
    }

    .sub-category-right {
        position: absolute;
        top: 6px;
        right: -24px;
        z-index: 9999999999999999999999999999;
        padding: 8px;
        width: 115px;
        font-size: 12px;
        text-align: center;
        border-top-right-radius: 13px;
    }

    .trip-button {
        font-weight: bold;
        background: #cf9b03;
        color: #000000;
        padding: 10px;
        width: 90%;
        margin: auto;
        justify-content: center;
        border-radius: 9px;
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }
</style>

<body class="relative -z-20">
    <x-china-header :title="__('messages.تفاصيل الرحلة')" :route="route('mobile.welcome')" />

    <div class="container min-h-dvh relative overflow-hidden pb-8 dark:text-white -z-10 dark:bg-color1">
        {{-- @if ($banner?->image) --}}
        <img class="main-image" src="{{ asset('images/trips/' . $trip->image) }}" max-height="300px" alt="">
        {{-- @endif --}}
        <div class="relative z-10">
            <div class="main-image-container">
                <div>
                    <div class="py-5 bg-white dark:bg-color10">
                        <div style="border-bottom: 1px dashed rgba(150, 147, 147, 0.401) !important;" class="text-center pb-4 border-b border-dashed border-black dark:border-color24 border-opacity-10 ">
                            <p class="font-semibold text-sm" style="margin-bottom: 15px;">
                                {{ app()->getLocale() == 'en'
                                ? $trip->title_en
                                : (app()->getLocale() == 'zh'
                                ? $trip->title_zh
                                : $trip->title_ar) }}
                            </p>
                        </div>
                        <img src="{{ asset('assets/assets/images/fly-GIF.gif') }}" class="fly-img" style="z-index: 999;" alt="">
                        <div style="position: relative; top: -30px; gap: 30px;" class="flex justify-between items-center">
                            <div class="flex justify-start items-center gap-2">
                                <div class="text-center">
                                    <span class="text-sm">{{
                                        \Carbon\Carbon::parse($trip->departure_date)->translatedFormat('l') }}</span>
                                    <div style="background-color: white;" class="py-1 px-2 bg-p2 rounded-lg">
                                        <p class="font-semibold text-lg font-bold">
                                            {{ \Carbon\Carbon::parse($trip->departure_date)->format('m/d') }}</p>
                                        <p class="text-[19px] font-bold">
                                            {{ \Carbon\Carbon::parse($trip->departure_date)->format('Y') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-start items-center gap-2">
                                <div class="text-center">
                                    <span class="text-sm">{{
                                        \Carbon\Carbon::parse($trip->return_date)->translatedFormat('l') }}</span>
                                    <div style="background-color: white;" class="py-1 px-2 bg-p2 rounded-lg ">
                                        <p class="font-semibold text-lg font-bold">
                                            {{ \Carbon\Carbon::parse($trip->return_date)->format('m/d') }}</p>
                                        <p class="text-[19px] font-bold">
                                            {{ \Carbon\Carbon::parse($trip->return_date)->format('Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                                
                                if ($trip->room_type == 'shared') {
                                    $room_type = 'مشتركة';
                                } elseif ($trip->room_type == 'private') {
                                    $room_type = 'خاصة';
                                }
                                ?>
                        @if ($trip->private_room_price)
                        <div class="flex justify-between items-center">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <p class="tab-details-content" style="display: flex; flex-direction: column; align-items: center;">
                                    <i class="fa-solid fa-bed" style="color: maroon;"></i>
                                    نوع الغرفة
                                    خاصه
                                    <span style="display: flex; align-items: center;">{{ $trip->shared_room_price }}<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M8 7V17H12C14.8 17 17 14.8 17 12C17 9.2 14.8 7 12 7H8Z" stroke="#000" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round">
                                            </path>
                                            <path d="M6.5 11H18.5" stroke="#000" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round">
                                            </path>
                                            <path d="M6.5 13H12.5H18.5" stroke="#000" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round">
                                            </path>
                                        </svg></span>
                                </p>
                                <p class="tab-details-content" style="display: flex; flex-direction: column; align-items: center;">
                                    <i class="fa-solid fa-bed" style="color: maroon;"></i>نوع الغرفة
                                    مشتركة

                                    <span style="display: flex; align-items: center;">{{ $trip->private_room_price }}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M8 7V17H12C14.8 17 17 14.8 17 12C17 9.2 14.8 7 12 7H8Z" stroke="#000" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round">
                                            </path>
                                            <path d="M6.5 11H18.5" stroke="#000" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round">
                                            </path>
                                            <path d="M6.5 13H12.5H18.5" stroke="#000" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round">
                                            </path>
                                        </svg></span>
                                </p>
                            </div>
                        </div>
                        @else
                        <div class="flex justify-between items-center">
                            <div style="display: flex; align-items: center; justify-content: center;">
                                <p class="tab-details-content" style="display: flex; flex-direction: column; align-items: center;">نوع الغرفة<i class="fa-solid fa-bed" style="color: maroon;"></i>
                                    <span style="display: flex; align-items: center;">{{ $room_type }}</span>
                                    <span style="display: flex; align-items: center;">{{ $trip->price }} <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M8 7V17H12C14.8 17 17 14.8 17 12C17 9.2 14.8 7 12 7H8Z" stroke="#000" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round">
                                            </path>
                                            <path d="M6.5 11H18.5" stroke="#000" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round">
                                            </path>
                                            <path d="M6.5 13H12.5H18.5" stroke="#000" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round">
                                            </path>
                                        </svg></span>
                                </p>
                            </div>
                        </div>
                        @endif
                    </div>

                    {{-- <a href="{{ route('mobile.auth.step2', ['trip_id' => $trip->id]) }}" class="trip-button">الاشتراك</a> --}}
                </div>
            </div>
            <div class="tabs-container">
                <div class="tab-buttons">
                    <button class="tab-button active details" onclick="showTab('tab1')">التفاصيل</button>
                    <button class="tab-button" onclick="showTab('tab2')">الارشادات</button>
                    <button class="tab-button rating" onclick="showTab('tab3')">المميزات</button>
                    <button class="tab-button rating" onclick="showTab('tab4')">الجدول</button>
                </div>
                <div id="tab4" class="tab-content">
                    @foreach ($activities as $date => $dailyActivities)
                    {{-- عرض التاريخ مرة واحدة فقط --}}
                    <div style="color: maroon; margin-bottom: 15px; font-weight: bold; font-size: 16px;">
                        <i class="fa fa-calendar"></i>
                        {{ \Carbon\Carbon::parse($date)->format('Y-m-d') }}
                    </div>

                    {{-- عرض جميع الأنشطة لهذا التاريخ --}}
                    @foreach ($dailyActivities as $activity)
                    <div class="flex flex-col gap-4" style="margin-bottom: 10px;">
                        <div class="rounded-2xl overflow-hidden quiz-link">
                            <div class="quiz-link p-2 bg-white dark:bg-color10">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 7px;">
                                </div>
                                <div style="position: relative; top: -30px;" class="border-b border-dashed border-black dark:border-color24 border-opacity-10 flex justify-between items-center">
                                    <div class="sub-category">
                                        @if($activity->place?->subCategory->name_ar)
                                        <p>{{ $activity->place->subCategory->name_ar}}</p>
                                        @else
                                        <p>جديد</p>
                                        @endif
                                    </div>
                                    <div class="sub-category-right">
                                        @php
                                        $periodTranslation = '';
                                        switch($activity->period) {
                                        case 'morning':
                                        $periodTranslation = '<img src="' . asset('assets/assets/images/mor2.png') . '">';
                                        break;
                                        case 'afternoon':
                                        $periodTranslation = '<img src="' . asset('assets/assets/images/noon2.png') . '">';
                                        break;
                                        case 'evening':
                                        $periodTranslation = '<img src="' . asset('assets/assets/images/nghit2.png') . '">';
                                        break;
                                        default:
                                        $periodTranslation = $activity->period;
                                        }
                                        @endphp
                                        {!! $periodTranslation !!}
                                    </div>
                                    @if ($activity->is_place_related == 0)
                                    <img src="{{ asset('storage/' . $activity?->image) }}" class="fly-img-order" alt="">
                                    @else
                                    <img src="{{ asset('storage/' . $activity?->place->avatar ?? '') }}" class="fly-img-order" alt="">
                                    @endif
                                </div>

                                <div style="" class="text-center pb-4">
                                    <p class="font-semibold text-sm">
                                        {{-- {{ $activity->place->name_ar }} --}}
                                        @if ($activity->is_place_related == 0)
                                        {!! app()->getLocale() == 'en'
                                        ? $activity?->place_name_en
                                        : (app()->getLocale() == 'zh'
                                        ? $activity?->place_name_zh
                                        : $activity?->place_name_ar) !!}
                                        @else
                                        {!! app()->getLocale() == 'en'
                                        ? $activity?->place->name_en
                                        : (app()->getLocale() == 'zh'
                                        ? $activity?->place->name_zh
                                        : $activity?->place->name_ar) !!}
                                        @endif
                                    </p>
                                    <p class="text-xs pt-2">
                                        {{-- {{ $activity->place->details_ar }} --}}
                                        <p class="text-xs pt-2">
                                            @if ($activity->is_place_related == 0)
                                            {!! app()->getLocale() == 'en'
                                            ? $activity->details_en
                                            : (app()->getLocale() == 'zh'
                                            ? $activity->details_zh
                                            : $activity->details_ar) !!}
                                            @else
                                            {!! app()->getLocale() == 'en'
                                            ? $activity->place->details_en
                                            : (app()->getLocale() == 'zh'
                                            ? $activity->place->details_zh
                                            : $activity->place->details_ar) !!}
                                            @endif
                                        </p>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    {{-- خط فاصل بين الأيام --}}
                    @if (!$loop->last)
                    <hr style="margin: 20px 0; border-color: #ddd;">
                    @endif
                    @endforeach
                </div>

                <div id="tab3" class="tab-content">
                    @if ($trip->trip_features)
                    <div class=" bg-gray-100 p-4 rounded-lg shadow-sm">
                        <h3 class="font-semibold text-lg mb-4 text-right text-gray-700 border-b pb-2">مميزات الرحلة
                        </h3>
                        <ul class="list-disc list-inside text-right text-gray-600">
                            @php
                            $features = $trip->trip_features;
                            if (is_string($features)) {
                            $features = json_decode($features, true);
                            }
                            @endphp

                            @forelse ($features as $feature_id)
                            @php
                            // التأكد من أن القيمة رقم قبل البحث عنها
                            if (is_numeric($feature_id)) {
                            $feature = \App\Models\TripFeatures::find($feature_id);
                            } else {
                            $feature = null;
                            }
                            @endphp
                            @if ($feature)
                            <li>{{ $feature?->name_ar }}</li>
                            @endif
                            @empty
                            <li>لا توجد مميزات مُضافة.</li>
                            @endforelse
                        </ul>
                    </div>
                    @endif
                </div>

                <div id="tab2" class="tab-content">

                    @if ($trip->trip_guidelines)
                    <div class="bg-gray-100 p-4 rounded-lg shadow-sm">
                        <h3 class="font-semibold text-lg mb-4 text-right text-gray-700 border-b pb-2">إرشادات
                            الرحلة
                        </h3>
                        <ul class="list-disc list-inside text-right text-gray-600">
                            @php
                            $guidelines = $trip->trip_guidelines;
                            if (is_string($guidelines)) {
                            $guidelines = json_decode($guidelines, true);
                            }
                            @endphp

                            @forelse ($guidelines as $guideline_id)
                            @php
                            if (is_numeric($guideline_id)) {
                            $guideline = \App\Models\TripGuideline::find($guideline_id);
                            } else {
                            $guideline = null;
                            }
                            @endphp
                            @if ($guideline)
                            <li>{{ $guideline?->name_ar }}</li>
                            @endif
                            @empty
                            <li>لا توجد إرشادات مُضافة.</li>
                            @endforelse
                        </ul>
                    </div>
                    @endif

                </div>

                <div id="tab1" class="tab-content">
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <p class="tab-details-content" style="display: flex; flex-direction: column; align-items: center;">
                            <i class="fa-solid fa-square-h" style="color: maroon;"></i>
                            <span style="color: maroon">
                                فندق الاقامة
                            </span>
                            {{ app()->getLocale() == 'en'
                            ? $trip->hotel_en
                            : (app()->getLocale() == 'zh'
                            ? $trip->hotel_zh
                            : $trip->hotel_ar) }}
                        </p>
                        <p class="tab-details-content" style="display: flex; flex-direction: column; align-items: center;">
                            <i class="fa-solid fa-car" style="color: maroon;"></i>
                            <span style="color: maroon">
                                مركبة خاصة
                            </span>
                            {{ $trip->transportation_type == 'shared_bus'
                            ? 'حافلة خاصة مشتركة'
                            : ($trip->transportation_type == 'private_car'
                            ? 'سيارة خاصة'
                            : ($trip->transportation_type == 'airport_only'
                            ? 'من وإلي المطار فقط'
                            : 'بدون مواصلات')) }}
                        </p>
                    </div>

                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <p class="tab-details-content" style="display: flex; flex-direction: column; align-items: center;">
                            <i class="fa-solid fa-language" style="color: maroon;"></i>
                            <span style="color: maroon">
                                المترجمين
                            </span>
                            {{ $trip->translators == 'group_translator'
                            ? 'للمجموعة'
                            : ($trip->translators == 'private_translator'
                            ? 'خاص لكل شخص'
                            : ($trip->translators == 'none'
                            ? 'لا يوجد'
                            : '')) }}
                        </p>
                        <p class="tab-details-content" style="display: flex; flex-direction: column; align-items: center;">
                            <i class="fa-solid fa-utensils" style="color: maroon;"></i>
                            <span style="color: maroon">
                                وجبات الطعام
                            </span>
                            {{ is_array($trip->meals) && !empty($trip->meals)
                            ? implode(
                            ', ',
                            array_map(function ($meal) {
                            switch ($meal) {
                            case 'breakfast':
                            return 'فطار';
                            case 'lunch':
                            return 'غداء';
                            case 'dinner':
                            return 'عشاء';
                            default:
                            return '';
                            }
                            }, $trip->meals),
                            )
                            : '' }}
                        </p>
                    </div>
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <p class="tab-details-content" style="display: flex; flex-direction: column; align-items: center;">
                            <i class="fa-solid fa-user" style="color: maroon;"></i>
                            <span style="color: maroon">
                                استقبال بالمطار
                            </span>
                            {{ $trip->airport_pickup == '1' ? 'نعم' : 'لا' }}
                        </p>
                        <p class="tab-details-content" style="display: flex; flex-direction: column; align-items: center;">
                            <img src="{{ asset('assets/assets/images/omda-icon (1).png') }}" style="width: 30px; height: 19px;" alt="">
                            <span style="color: maroon">مشرف من عمدة الصين</span>
                            {{ $trip->supervisor == '1' ? 'نعم' : 'لا' }}
                        </p>
                    </div>

                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <p class="tab-details-content" style="display: flex; flex-direction: column; align-items: center;">
                            <i class="fa-solid fa-industry" style="color: maroon;"></i>
                            <span style="color: maroon">
                                زيارة المصانع
                            </span>
                            {{ $trip->factory_visit == '1' ? 'نعم' : 'لا' }}
                        </p>
                        <p class="tab-details-content" style="display: flex; flex-direction: column; align-items: center;">
                            <i class="fa-solid fa-torii-gate" style="color: maroon;"></i>
                            <span style="color: maroon">
                                زيارة المواقع السياحية
                            </span>
                            {{ $trip->tourist_sites_visit == '1' ? 'نعم' : 'لا' }}
                        </p>
                    </div>

                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <p class="tab-details-content" style="display: flex; flex-direction: column; align-items: center;">
                            <i class="fa-solid fa-ticket" style="color: maroon;"></i>
                            <span style="color: maroon">
                                يشمل التذاكر
                            </span>
                            {{ $trip->tickets_included == '1' ? 'نعم' : 'لا' }}
                        </p>
                        <p class="tab-details-content" style="display: flex; flex-direction: column; align-items: center;">
                            <i class="fa-solid fa-wallet" style="color: maroon;"></i>
                            <span style="color: maroon">
                                سعر الرحلة
                            </span>
                            {{ $trip->price }}
                        </p>
                    </div>

                </div>

            </div>
            <div id="ratingModal" class="modal-overlay" onclick="closeModalOnOverlay(event)">
                <div class="modal">
                    <button class="modal-close" onclick="closeRatingModal()">
                        <i class="fa fa-x"></i>
                    </button>
                    <h3 class="modal-title">
                        <i class="fa fa-chat-circle-text" style="color: maroon;"></i>
                        ما رأيك في هذا المكان؟
                    </h3>
                    <div class="modal-rating-display" id="modalStars">
                        <i class="fa-solid fa-star modal-star"></i>
                        <i class="fa-solid fa-star modal-star"></i>
                        <i class="fa-solid fa-star modal-star"></i>
                        <i class="fa-solid fa-star modal-star"></i>
                        <i class="fa-solid fa-star modal-star"></i>
                    </div>
                    <textarea id="commentInput" class="modal-comment" placeholder="شاركنا تجربتك وانطباعك عن هذا المكان... (اختياري)"></textarea>
                    <div class="modal-actions">
                        <button class="modal-button cancel-button" onclick="closeRatingModal()">إلغاء</button>
                        <button class="modal-button confirm-button" onclick="confirmRating()">تأكيد التقييم</button>
                    </div>
                </div>
            </div>
            <div id="imageModal" class="modal-overlay" onclick="closeImageModalOnOverlay(event)">
                <div class="image-modal">
                    <button class="modal-close" onclick="closeImageModal()">
                        <i class="fa fa-x"></i>
                    </button>
                    <img id="modalImage" src="" alt="">
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterItems = document.querySelectorAll('.item');
            const tripCards = document.querySelectorAll('.trip-card');

            filterItems.forEach(item => {
                item.addEventListener('click', function() {
                    // Remove active class from all items
                    filterItems.forEach(i => i.classList.remove('active'));
                    // Add active class to clicked item
                    this.classList.add('active');

                    const filterValue = this.getAttribute('data-filter');

                    // Show/hide trip cards based on filter
                    tripCards.forEach(card => {
                        const tripType = card.getAttribute('data-trip-type');
                        if (filterValue === 'all' || tripType === filterValue) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });
        });

    </script>
    <script>
        let currentRating = 0;
        let allReviews = [{
                id: 1
                , name: "أحمد محمد"
                , rating: 5
                , comment: "مكان رائع جداً! الخدمة ممتازة والموقع مثالي. أنصح الجميع بزيارته."
                , date: "2024-01-15"
                , avatar: "أ"
            }
            , {
                id: 2
                , name: "فاطمة علي"
                , rating: 4
                , comment: "تجربة جميلة، المكان نظيف ومرتب. الوحيد العيب أن الأسعار مرتفعة قليلاً."
                , date: "2024-01-10"
                , avatar: "ف"
            }
            , {
                id: 3
                , name: "محمد حسن حسن...."
                , rating: 3
                , comment: "المكان جيد لكن يحتاج تحسينات في الخدمة."
                , date: "2024-01-05"
                , avatar: "م"
            }
            , {
                id: 4
                , name: "نور الدين"
                , rating: 5
                , comment: "ممتاز! أجمل مكان زرته في المدينة. الجو رائع والطاقم محترف."
                , date: "2023-12-28"
                , avatar: "ن"
            }
            , {
                id: 5
                , name: "سارة أحمد"
                , rating: 4
                , comment: "مكان جميل ومناسب للعائلات، لكن يحتاج مواقف سيارات أكثر."
                , date: "2023-12-20"
                , avatar: "س"
            }
        ];

        function calculateAverageRating() {
            if (allReviews.length === 0) return 0;
            const sum = allReviews.reduce((acc, review) => acc + review.rating, 0);
            return (sum / allReviews.length).toFixed(1);
        }

        function updateAverageRating() {
            const avgRating = calculateAverageRating();
            const avgElement = document.getElementById('avgRating');
            const totalElement = document.getElementById('totalReviews');
            const starsElement = document.getElementById('avgStars');

            avgElement.textContent = avgRating;
            totalElement.textContent = `(${allReviews.length} تقييم)`;

            const stars = starsElement.querySelectorAll('i');
            const rating = parseFloat(avgRating);
            stars.forEach((star, index) => {
                if (index < Math.floor(rating)) {
                    star.className = 'fa-solid fa-star';
                } else if (index < rating) {
                    star.className = 'fa-regular fa-star-half';
                } else {
                    star.className = 'fa-regular fa-star';
                }
            });
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            const diffTime = Math.abs(now - date);
            const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));

            if (diffDays === 0) return 'اليوم';
            if (diffDays === 1) return 'أمس';
            if (diffDays < 7) return `منذ ${diffDays} أيام`;
            if (diffDays < 30) return `منذ ${Math.floor(diffDays / 7)} أسابيع`;
            return date.toLocaleDateString('en-US');
        }

        function createStars(rating) {
            let starsHtml = '';
            for (let i = 1; i <= 5; i++) {
                if (i <= rating) {
                    starsHtml += '<i class="fa-solid fa-star"></i>';
                } else {
                    starsHtml += '<i class="fa-regular fa-star"></i>';
                }
            }
            return starsHtml;
        }

        function renderReviews() {
            const reviewsList = document.getElementById('reviewsList');

            if (allReviews.length === 0) {
                reviewsList.innerHTML =
                    '<div class="no-reviews">لا توجد تقييمات حتى الآن. كن أول من يقيم هذا المكان!</div>';
                return;
            }

            const sortedReviews = allReviews.sort((a, b) => new Date(b.date) - new Date(a.date));

            reviewsList.innerHTML = sortedReviews.map(review => `
                    <div class="review-item ${review.isNew ? 'new-review' : ''}" data-id="${review.id}">
                      <div class="review-header">
                        <div class="reviewer-info">
                          <div class="reviewer-avatar">${review.avatar}</div>
                          <div>
                            <div class="reviewer-name">${review.name}</div>
                            <div class="review-date">${formatDate(review.date)}</div>
                          </div>
                        </div>
                        <div class="review-rating">
                          <div class="review-stars">
                            ${createStars(review.rating)}
                          </div>
                        </div>
                      </div>
                      ${review.comment ? `<div class="review-comment">${review.comment}</div>` : ''}
                      <button class="report-button" onclick="openReportModal()">مخالفة</button>
                    </div>
                  `).join('');

            setTimeout(() => {
                const newReviews = document.querySelectorAll('.new-review');
                newReviews.forEach(review => {
                    review.classList.remove('new-review');
                });
            }, 3000);
        }


        function openReportModal() {
            Swal.fire({
                title: "مخالفة"
                , text: 'هل هذا المحتوي مخالف'
                    // , showDenyButton: true
                , showCancelButton: true
                , confirmButtonText: "نعم"
                , cancelButtonText: "لا"
            }).then((result) => {
                let reportType = '';
                if (result.isConfirmed) {
                    reportType = 'content_report';
                } else if (result.isDenied) {
                    reportType = 'fake_account';
                }

                if (reportType) {
                    // ابحث عن الـ ChefProfile من الـ user_id
                    fetch(`/chef-profile/report-by-user/${userId}`, {
                            method: 'POST'
                            , headers: {
                                'Content-Type': 'application/json'
                                , 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                                , 'Accept': 'application/json'
                            }
                            , body: JSON.stringify({
                                report_type: reportType
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire("تم الإبلاغ!", "شكراً لك. سيتم مراجعة بلاغك.", "success");
                                const reportBtn = document.querySelector('.report-btn');
                                if (reportBtn) {
                                    reportBtn.innerHTML = 'تم الإبلاغ';
                                    reportBtn.style.background = 'gray';
                                    reportBtn.onclick = null;
                                    reportBtn.style.cursor = 'default';
                                }
                            } else {
                                Swal.fire("حدث خطأ!", data.message || "فشل إرسال البلاغ.", "error");
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire("حدث خطأ!", "فشل في التواصل مع الخادم.", "error");
                        });
                }
            });
        }



        function openRatingModal(rating) {
            currentRating = rating;
            const modal = document.getElementById('ratingModal');
            const stars = document.querySelectorAll('.modal-star');

            modal.classList.add('show');

            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.add('filled');
                } else {
                    star.classList.remove('filled');
                }
            });

            updateSelectedRating(rating);
            document.getElementById('commentInput').value = '';
        }

        function updateSelectedRating(rating) {
            const boxes = document.querySelectorAll('.rating-box');
            boxes.forEach((box, index) => {
                if (index + 1 <= rating) {
                    box.classList.add('selected');
                } else {
                    box.classList.remove('selected');
                }
            });
        }

        function closeRatingModal() {
            const modal = document.getElementById('ratingModal');
            modal.classList.remove('show');

            const boxes = document.querySelectorAll('.rating-box');
            boxes.forEach(box => box.classList.remove('selected'));
        }

        function closeModalOnOverlay(event) {
            if (event.target.classList.contains('modal-overlay')) {
                closeRatingModal();
            }
        }

        function confirmRating() {
            if (!validateRating()) {
                return;
            }

            const comment = document.getElementById('commentInput').value.trim();

            const newReview = {
                id: Date.now()
                , name: "أنت"
                , rating: currentRating
                , comment: comment || null
                , date: new Date().toISOString().split('T')[0]
                , avatar: "أ"
                , isNew: true
            };

            allReviews.unshift(newReview);

            updateAverageRating();
            renderReviews();

            closeRatingModal();
            showSuccessMessage();

            console.log('تم إضافة تقييم جديد:', newReview);
            console.log('إجمالي التقييمات:', allReviews.length);
        }

        function showSuccessMessage() {
            const successMsg = document.getElementById('successMessage');
            successMsg.classList.add('show');

            setTimeout(() => {
                successMsg.classList.remove('show');
            }, 3000);
        }

        function showTab(tabId) {
            const contents = document.querySelectorAll('.tab-content');
            contents.forEach(content => {
                content.style.display = 'none';
            });

            const buttons = document.querySelectorAll('.tab-button');
            buttons.forEach(button => {
                button.style.backgroundColor = 'black';
                button.style.color = 'white';
            });

            document.getElementById(tabId).style.display = 'block';

            const active_button = document.querySelector(`[onclick="showTab('${tabId}')"]`);
            active_button.style.backgroundColor = 'maroon';
            active_button.style.color = 'white';

            if (tabId === 'tab3') {
                updateAverageRating();
                renderReviews();
            }
        }

        function openImageModal(src) {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            modalImage.src = src;
            modal.classList.add('show');
        }

        function closeImageModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.remove('show');
        }

        function closeImageModalOnOverlay(event) {
            if (event.target.classList.contains('modal-overlay')) {
                closeImageModal();
            }
        }

        window.onload = function() {
            showTab('tab1');
        };

        function playClickSound() {}

        function shakeModal() {
            const modal = document.querySelector('.modal');
            modal.style.animation = 'shake 0.5s ease-in-out';
            setTimeout(() => {
                modal.style.animation = '';
            }, 500);
        }

        function validateRating() {
            if (currentRating < 1 || currentRating > 5) {
                shakeModal();
                return false;
            }
            return true;
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeRatingModal();
                closeImageModal();
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            updateAverageRating();
            renderReviews();
            const modal = document.querySelector('.modal');
            if (modal) {
                modal.addEventListener('click', function(event) {
                    event.stopPropagation();
                });
            }
            const imageModal = document.querySelector('.image-modal');
            if (imageModal) {
                imageModal.addEventListener('click', function(event) {
                    event.stopPropagation();
                });
            }
        });

    </script>
</body>
@endsection
