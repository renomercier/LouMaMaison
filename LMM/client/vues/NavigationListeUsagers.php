<!--
* @file         /AfficheListeUsagers.php
* @brief        Projet WEB 2
* @details      Affichage de tous les usagers - vue partielle
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018
-->

<div class="container">
    <div class="filtre_usager">
        <ul class="nav nav-tabs flex-column flex-md-row">
          <li class="nav-item">
            <a class="nav-link active" onclick="filtrerUsagers('', '')" name="" value="">Tous</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" onclick="filtrerUsagers('role', 'client')" name="role" value="client">Clients</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" onclick="filtrerUsagers('role', 'proprio')" name="role" value="proprio">Propriétaires</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" onclick="filtrerUsagers('valide', 1)" name="valide" value="1">Actifs</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" onclick="filtrerUsagers('attente', 1)" name="attente" value="1">En attente</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" onclick="filtrerUsagers('banni', 1)" name="banni" value="1">Bannis</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" onclick="filtrerUsagers('role', 'admin')" name="role" value="admin">Administrateurs</a>
          </li>
        </ul>
    </div>
<div class="content">
    <div class="usagers">