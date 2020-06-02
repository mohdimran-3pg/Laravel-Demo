<style>

    #book-info-model{
        height: 100%;
    }
    .row-content{
        height: 1500px;
    }
    .col-content{
        height: 1400px;
    }
    .book-img {
        width: 267px;
        height: 317px;
    }
    .book-title {
        color: #394A58;
        font-size: 28px;
        font-weight: bold;
        line-height: 34px;
        text-align: left;
    }

    .author-info {
        color: #818A8F;
        line-height: 19px;
        text-align: left;
    }

    .book-no {
        text-transform: uppercase;
        font-weight: bold;
    }

    .book-description {
        color: #000000;
        font-size: 14px;
        line-height: 19px;
        text-align: left;
    }

    .searchResult-issueBookButton {
        background-color: #00A9E0;
        border-radius: 10px;
        box-shadow: 0 1px 6px 0 rgba(16, 77, 105, 0.44);
        width: 151px;
        height: 40px;
        margin-top: 30px;
        margin-right: 15px;
        opacity: 1;
    }

    .searchResult-issueBookButton-Text {
        color: #FFFFFF;
        /* font-family: Roboto; */
        font-size: 14px;
        font-weight: 400;
        line-height: 17px;
        width: 96px;
        text-align: left;
    }

    .info-label {
        text-align: left;
        font-size: 14px;
        margin-top: 12px;
    }
    .info-label span {
        font-weight: bold;
    }

</style>


<div class="container" id="book-info-model" style="margin-top:100px">
    <div class="row row-content">
        <div class="col-md-3 col-content">
            <div class="book-img">
                <img class="book-img" src="/media/books/bk034.jpg" />
            </div>
            <div class="category-info info-label">
                <span>Category :</span> Technology
            </div>
            <div class="sub-category-info info-label">
                <span>Subcategory :</span> Web Development
            </div>
        </div>
        <div class="col-md-7 col-content">
            <div class="book-title">
                Web Technologies: HTML, JAVASCRIPT, PHP, JAVA, JSP, XML and AJAX, Black Book
            </div>
            <div class="author-info">
                by <span class="author-name">Kogent Learning Solutions Inc</span>
            </div>
            <div class="book-no">
                BOOKNO1102912
            </div>
            <div class="book-description">
                Web Technologies Black Book is a one-time reference book, written from a programmer’s point of view, containing hundreds of examples and covering nearly every aspect of various Web Technologies, such as HTML5, CSS3, JAVASCRIPT, jQUERY, AJAX, PHP, XML, MVC and LARAVEL. It will help you to master the entire spectrum of Web Technologies by exploring and implementing various concepts of each technology.
                <br />
                <br />
                Knowledge panels are extremely valuable to your business. They help your business get discovered and stand out from the competition. It's one of the first things your audience will see when they conduct a search for a business like yours.
                <br />
                <br />
                This guide will teach you 6 different methods to generate Google Knowledge Panel and update information in knowledge panel. Knowledge panel is very important thing these days because it can increase the chances of getting verified on social media.
            </div>


        <div class="issue-button">
            <button class="searchResult-issueBookButton" onclick="issueBookUser(this)" data-content="BK099" data-bookid="102">
                <text class="searchResult-issueBookButton-Text">
                    Issue this Book
                </text>
            </button>
        </div>
    </div>
</div>
</div>