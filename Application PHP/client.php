<!DOCTYPE html>
<html>
<head>
	<title>bienvenue</title>
	<meta charset="utf-8">
	<style>
  
    
   
    .d{
       font-family: "Roboto",sans-serif;
       position: relative;
       z-index: 1;
       z-index: 1;
       background: #F0E68C;
        opacity: 99%;
        max-width: 900px;
        height: 350px; 
       box-shadow: 0 0 20px 0 rgba(0,0,0,0.2),0 5px 5px 0 rgba(0,0,0,0.24);
       border-radius: 10px;
      display:flex;
      justify-content: space-around;
  
      
      
    }
    
    h3{
      
      text-align: center;
     
    }
    input{
      outline: 0;
      border-radius: 10px;
      background: #F2F2F2;
      width: 100%;
      border:0;
      margin: 0 0 15px;
      padding: 15px;
      box-sizing: border-box;
      font-size: 14px;
    }
    input:hover{
      background-color:yellow;
      transition: all 1s ease 0s;
    }
    input:focus{
      background-color: yellow;
      transition: all 1s ease 0s;
    }
    button{
      text-transform: uppercase;
      outline: 0;
      border-radius: 10px;
      background:orange;
      width: 100%;
      border: 0;
      padding: 15px;
      color: #FFFFFF;
      font-size: 14px;
      cursor: pointer;
    }
    button:hover , button:active, button:focus{
         background-color: #06C5CF;
         transition: all 1s ease 0s;
    }
    .C{
      background-color: black;
      color: yellow;
    }
   
  </style>
</head>
<body>
 
 <div class="C">
  <center><h1>Chiffre d'Affaire - GestCom</h1></center>
 </div>
 
<center>
  
<div class="d">
   <div class="E">
    <form method="POST" action="server.php">
    <h3>Chiffre d'Affaire d'un client</h3>
    <p>Code Client</p>
    <input type="text" name="codeclient" placeholder="Code client">
    <p>A Partir de</p> 
    <input type="text" name="date" placeholder="yyyy-mm-dd" >
    <input type="text" name="val" value='1' hidden readonly>
    <button>Afficher</button>
    </form>
   </div>

    <div class="F">
      <form  method="POST" action="server.php">
      </br></br></br></br></br></br>
      <h3>Chiffre d'Affaire globale</h3>
      <p>A Partir de</p> 
      <input type="text" name="dateG" placeholder="yyyy-mm-dd">
      <input type="text" name="val" value='2' hidden readonly>
      <button>Afficher</button>
      </form> </div>
     </div> 

</center>  




</body>
</html>