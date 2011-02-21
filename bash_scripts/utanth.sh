#!/bin/bash
# Installer Script for Unreal Anthology, written by Wayne Moulden
VERSION=UNREAL_ANTHOLOGY
#
# User Variables here
# GAME options
# 1 - Not Supported/Unreal Gold/UnrealGold
# 2 - Not Supported/Unreal 2/Unreal2
# 3 - Unreal Tournament GOTY/UnrealTournament
# 4 - Unreal Tournament 2004/UT2004
#
# LANG Options
# English
# Italian
# French
# Spanish
#
# MEDIA Variable
# Set to wherever the DVD is mounted
#
GAME=4
LANG=English
DEST=/usr/local/games
MEDIA=/usr/downloads/ut/ua
#MEDIA=/media/${VERSION}
UTGRP="games"

TEMPDIR="/tmp/${VERSION}"
EXTRAS="${TEMPDIR}/extras"
COMMAND="unshield x ${TEMPDIR}/data"
ARCH=`uname -m`

function extractCOMMON {
    echo "Extracting Common Files, Please Wait..."
    ${COMMAND} -g ${GAME}_${GAMETYPE}_Help -d ${TEMPDIR}/${GAMETYPE} > /dev/null
    ${COMMAND} -g ${GAME}_${GAMETYPE}_Manual -d ${TEMPDIR}/${GAMETYPE} > /dev/null
    ${COMMAND} -g ${GAME}_${GAMETYPE}_Manual_${LANG} -d ${TEMPDIR}/${GAMETYPE} > /dev/null
    ${COMMAND} -g ${GAME}_${GAMETYPE}_Maps -d ${TEMPDIR}/${GAMETYPE} > /dev/null
    ${COMMAND} -g ${GAME}_${GAMETYPE}_Music -d ${TEMPDIR}/${GAMETYPE} > /dev/null
    ${COMMAND} -g ${GAME}_${GAMETYPE}_Sounds_All -d ${TEMPDIR}/${GAMETYPE} > /dev/null
    ${COMMAND} -g ${GAME}_${GAMETYPE}_Sounds_${LANG} -d ${TEMPDIR}/${GAMETYPE} > /dev/null
    ${COMMAND} -g ${GAME}_${GAMETYPE}_System_All -d ${TEMPDIR}/${GAMETYPE} > /dev/null
    ${COMMAND} -g ${GAME}_${GAMETYPE}_System_${LANG} -d ${TEMPDIR}/${GAMETYPE} > /dev/null
    ${COMMAND} -g ${GAME}_${GAMETYPE}_Textures -d ${TEMPDIR}/${GAMETYPE} > /dev/null
}

function extractUnrealTournament {
   echo "Extracting ${GAMETYPE}"
   ${COMMAND} -g ${GAME}_${GAMETYPE}_Web -d ${TEMPDIR}/${GAMETYPE} > /dev/null
}

function dirsUnrealTournament {
    echo "Setting Up ${GAMETYPE} directories"
    mv ${TEMPDIR}/${GAMETYPE}/${GAME}_${GAMETYPE}_Web ${TEMPDIR}/${GAMETYPE}/Web
}

function extractUT2004 {
    echo "Extracting ${GAMETYPE} Files, Please Wait..."
    ${COMMAND} -g ${GAME}_${GAMETYPE}_Animations -d ${TEMPDIR}/${GAMETYPE} > /dev/null
    ${COMMAND} -g ${GAME}_${GAMETYPE}_Benchmark -d ${TEMPDIR}/${GAMETYPE} > /dev/null
    ${COMMAND} -g ${GAME}_${GAMETYPE}_Demos -d ${TEMPDIR}/${GAMETYPE} > /dev/null
    ${COMMAND} -g ${GAME}_${GAMETYPE}_ForceFeedback -d ${TEMPDIR}/${GAMETYPE} > /dev/null
    ${COMMAND} -g ${GAME}_${GAMETYPE}_KarmaData -d ${TEMPDIR}/${GAMETYPE} > /dev/null
    ${COMMAND} -g ${GAME}_${GAMETYPE}_Prefabs -d ${TEMPDIR}/${GAMETYPE} > /dev/null
    ${COMMAND} -g ${GAME}_${GAMETYPE}_Saves -d ${TEMPDIR}/${GAMETYPE} > /dev/null
    ${COMMAND} -g ${GAME}_${GAMETYPE}_ScreenShots -d ${TEMPDIR}/${GAMETYPE} > /dev/null
    ${COMMAND} -g ${GAME}_${GAMETYPE}_Speech -d ${TEMPDIR}/${GAMETYPE} > /dev/null
    ${COMMAND} -g ${GAME}_${GAMETYPE}_StaticMeshes -d ${TEMPDIR}/${GAMETYPE} > /dev/null
    ${COMMAND} -g ${GAME}_${GAMETYPE}_Web -d ${TEMPDIR}/${GAMETYPE} > /dev/null
}

function dirsUT2004 {
    echo "Setting Up ${GAMETYPE} directories"
    mv ${TEMPDIR}/${GAMETYPE}/${GAME}_${GAMETYPE}_Animations ${TEMPDIR}/${GAMETYPE}/Animations
    mv ${TEMPDIR}/${GAMETYPE}/${GAME}_${GAMETYPE}_Demos ${TEMPDIR}/${GAMETYPE}/Demos
    mv ${TEMPDIR}/${GAMETYPE}/${GAME}_${GAMETYPE}_Saves ${TEMPDIR}/${GAMETYPE}/Saves
    mv ${TEMPDIR}/${GAMETYPE}/${GAME}_${GAMETYPE}_StaticMeshes ${TEMPDIR}/${GAMETYPE}/StaticMeshes
    mv ${TEMPDIR}/${GAMETYPE}/${GAME}_${GAMETYPE}_UserMovies ${TEMPDIR}/${GAMETYPE}/UserMovies
    mv ${TEMPDIR}/${GAMETYPE}/${GAME}_${GAMETYPE}_Benchmark ${TEMPDIR}/${GAMETYPE}/Benchmark
    mv ${TEMPDIR}/${GAMETYPE}/${GAME}_${GAMETYPE}_ForceFeedback ${TEMPDIR}/${GAMETYPE}/ForceFeedback
    mv ${TEMPDIR}/${GAMETYPE}/${GAME}_${GAMETYPE}_KarmaData ${TEMPDIR}/${GAMETYPE}/KarmaData
    mv ${TEMPDIR}/${GAMETYPE}/${GAME}_${GAMETYPE}_Prefabs ${TEMPDIR}/${GAMETYPE}/Prefabs
    mv ${TEMPDIR}/${GAMETYPE}/${GAME}_${GAMETYPE}_ScreenShots ${TEMPDIR}/${GAMETYPE}/Screenshots
    mv ${TEMPDIR}/${GAMETYPE}/${GAME}_${GAMETYPE}_Speech ${TEMPDIR}/${GAMETYPE}/Speech
    mv ${TEMPDIR}/${GAMETYPE}/${GAME}_${GAMETYPE}_Web ${TEMPDIR}/${GAMETYPE}/Web

}

function permCOMMON {
    # Setup Permissions
    sudo chgrp -R ${UTGRP} ${TEMPDIR}/${GAMETYPE}/
    sudo chmod -R 775 ${TEMPDIR}/${GAMETYPE}/
}

function dirsCOMMON {
    echo "Setting up Common Directories"
    # Setup System Directory
    mv ${TEMPDIR}/${GAMETYPE}/${GAME}_${GAMETYPE}_System_All ${TEMPDIR}/${GAMETYPE}/System
    cp -R ${TEMPDIR}/${GAMETYPE}/${GAME}_${GAMETYPE}_System_${LANG}/* ${TEMPDIR}/${GAMETYPE}/System
    rm -rf ${TEMPDIR}/${GAMETYPE}/${GAME}_${GAMETYPE}_System_${LANG}/
    # Setup Help Directory
    mv ${TEMPDIR}/${GAMETYPE}/${GAME}_${GAMETYPE}_Help ${TEMPDIR}/${GAMETYPE}/Help
    cp -R ${TEMPDIR}/${GAMETYPE}/${GAME}_${GAMETYPE}_Manual_${LANG}/* ${TEMPDIR}/${GAMETYPE}/Help
    rm -rf ${TEMPDIR}/${GAMETYPE}/${GAME}_${GAMETYPE}_Manual_${LANG}/
    # Setup Sounds Directory
    mv ${TEMPDIR}/${GAMETYPE}/${GAME}_${GAMETYPE}_Sounds_All ${TEMPDIR}/${GAMETYPE}/Sounds
    cp -R ${TEMPDIR}/${GAMETYPE}/${GAME}_${GAMETYPE}_Sounds_${LANG}/* ${TEMPDIR}/${GAMETYPE}/Sounds
    rm -rf ${TEMPDIR}/${GAMETYPE}/${GAME}_${GAMETYPE}_Sounds_${LANG}/
    mv ${TEMPDIR}/${GAMETYPE}/${GAME}_${GAMETYPE}_Maps ${TEMPDIR}/${GAMETYPE}/Maps
    mv ${TEMPDIR}/${GAMETYPE}/${GAME}_${GAMETYPE}_Music ${TEMPDIR}/${GAMETYPE}/Music
    mv ${TEMPDIR}/${GAMETYPE}/${GAME}_${GAMETYPE}_Textures ${TEMPDIR}/${GAMETYPE}/Textures
    sudo mv ${TEMPDIR}/${GAMETYPE}/ ${DEST}/
}

# Check if unshield is installed
if [ `which unshield` = "/usr/bin/unshield" ]; then
  # Check for media in drive
  if [ -e ${MEDIA} ]; then
   rm -rf ${TEMPDIR}/
   # Create temporary directory
   if [ ! -f ${TEMPDIR}/ ]; then
    mkdir -p ${TEMPDIR}/
   fi

   if [ ! -f ${EXTRAS}/ ]; then
    mkdir -p ${EXTRAS}/
   fi

   echo ""
   echo ""
   echo "###############################################"
   echo "#           UT ANTHOLOGY INSTALLER            #"
   echo "#                                             #"
   echo "# 1 - Not Supported/Unreal Gold/UnrealGold    #"
   echo "# 2 - No Linux Version/Unreal 2/Unreal2       #"
   echo "# 3 - Unreal Tournament GOTY/UnrealTournament #"
   echo "# 4 - Unreal Tournament 2004/UT2004           #"
   echo "###############################################"
   echo "Installing game ${GAME} "
   echo "NOTE: sudo password may be required"
   # Link required files to tmp directory from DVD
   if [ ! -f ${TEMPDIR}/data1.cab ]
   then
     echo "Linking Files from ${MEDIA}"
     find ${MEDIA} -name "data*" -exec ln -s {} ${TEMPDIR}/ \;
   fi
#############################
# Unreal Tournament
#############################
   if [ ${GAME} = "3" ]; then
    GAMETYPE=UnrealTournament
    # Extraction happens here
    extractCOMMON
    extract${GAMETYPE}
    permCOMMON
    dirs${GAMETYPE}
    dirsCOMMON
    ######################################
    # SPECIFIC GAME INSTALLATION OPTIONS
    ######################################
    # Download and edit the loki installer
    cd ${EXTRAS}
    wget -q "http://www.liflg.org/?what=dl&catid=6&gameid=51&filename=unreal.tournament_436-multilanguage.goty.run" -O ${EXTRAS}/unreal.tournament_436-multilanguage.goty.run
    sh ${EXTRAS}/unreal.tournament_436-multilanguage.goty.run --tar -xvf > /dev/null
    mkdir ${TEMPDIR}/${GAMETYPE}/
    cp ${EXTRAS}/ut.xpm ${TEMPDIR}/${GAMETYPE}/System/
    tar xvf data.tar.gz -C ${TEMPDIR}/${GAMETYPE}/ > /dev/null
    tar xvf Credits.tar.gz -C ${TEMPDIR}/${GAMETYPE}/ > /dev/null
    tar xvf NetGamesUSA.com.tar.gz -C ${TEMPDIR}/${GAMETYPE}/ > /dev/null
    tar xvf UT436-OpenGLDrv-Linux-090602.tar.gz -C ${TEMPDIR}/${GAMETYPE}/ > /dev/null
    tar xvf OpenGL.ini.tar.gz -C ${TEMPDIR}/${GAMETYPE}/ > /dev/null
    sudo cp -R ${TEMPDIR}/${GAMETYPE}/* ${DEST}/${GAMETYPE}/
    ### UT Launch Script
        echo "Creating Launch Script"
        touch ${EXTRAS}/ut99
        echo "#!/bin/sh" > ${EXTRAS}/ut99
        echo "UT99_DATA_PATH=${DEST}/${GAMETYPE}/System" >> ${EXTRAS}/ut99
        echo "ARCH=`uname -m`" >> ${EXTRAS}/ut99
        echo "UTCOMMAND=ut-bin" >> ${EXTRAS}/ut99
        echo "" >> ${EXTRAS}/ut99
        echo 'if [ -x ${UT99_DATA_PATH}/${UTCOMMAND} ]' >> ${EXTRAS}/ut99
        echo "then" >> ${EXTRAS}/ut99
        echo '        cd ${UT99_DATA_PATH}/' >> ${EXTRAS}/ut99
        echo '        exec ./${UTCOMMAND} $*' >> ${EXTRAS}/ut99
        echo "fi" >> ${EXTRAS}/ut99
        sudo mv ${EXTRAS}/ut99 /usr/bin/
        chmod +x /usr/bin/ut99
   ### LAUNCHER
        echo "Creating Desktop Launcher"
        touch ${EXTRAS}/ut99.desktop
        echo "[Desktop Entry]" > ${EXTRAS}/ut99.desktop
        echo "Name=Unreal Tournament 2004" >> ${EXTRAS}/ut99.desktop
        echo "Comment=Unreal Tournament '99" >> ${EXTRAS}/ut99.desktop 
        echo "Exec=/usr/bin/ut99" >> ${EXTRAS}/ut99.desktop
        echo "Icon=/${DEST}/${GAMETYPE}/System/icon.xpm" >> ${EXTRAS}/ut99.desktop
        echo "Terminal=false" >> ${EXTRAS}/ut99.desktop
        echo "Type=Application" >> ${EXTRAS}/ut99.desktop
        echo "Categories=Application;Game;" >> ${EXTRAS}/ut99.desktop
        sudo mv ${EXTRAS}/ut99.desktop /usr/share/applications/
#############################
# Unreal Tournament 2004
#############################
   elif [ ${GAME} = "4" ]; then
    GAMETYPE=UT2004
    # Create Dummy Dirs for UT2K4, fix for errors, 
    # looks like they may be user dirs in ~/.ut2004
    mkdir -p ${TEMPDIR}/${GAMETYPE}/4_UT2004_Demos
    mkdir -p ${TEMPDIR}/${GAMETYPE}/4_UT2004_Saves
    mkdir -p ${TEMPDIR}/${GAMETYPE}/4_UT2004_UserMovies
    mkdir -p ${TEMPDIR}/${GAMETYPE}/4_UT2004_Prefabs
    mkdir -p ${TEMPDIR}/${GAMETYPE}/4_UT2004_ScreenShots
    mkdir -p ${TEMPDIR}/${GAMETYPE}/4_UT2004_Speech
    # Extraction happens here
    extractCOMMON
    extract${GAMETYPE}
    permCOMMON
    dirs${GAMETYPE}
    dirsCOMMON
    ######################################
    # SPECIFIC GAME INSTALLATION OPTIONS
    ######################################
    #
    mkdir -p /home/`whoami`/.ut2004/System
    cd ${EXTRAS}
    if [ ${ARCH} = "x86_64" ]
    then
       PACK="amd64"
       echo "Detected 64bit arch"
    elif [ ${ARCH} = "i686" ]
    then
       PACK="i386"
       echo "Detected 32bit arch"
    else
      echo "Couldnt detect arch"
    fi
    if [ ${PACK} ]
    then
        PACKAGE=libstdc++5_3.3.6-17ubuntu1_${PACK}.deb
	echo "Downloading ${PACKAGE} (300k)"
        wget -q http://fr.archive.ubuntu.com/ubuntu/pool/universe/g/gcc-3.3/${PACKAGE} -O ${EXTRAS}/${PACKAGE}
        sudo dpkg -i ${EXTRAS}/${PACKAGE} > /dev/null
    fi
    ### LIBS
    echo "Linking Required SDL Libraries"
    sudo rm -f ${DEST}/${GAMETYPE}/System/libSDL-1.2.so.0
    sudo rm -f ${DEST}/${GAMETYPE}/System/openal.so
    sudo ln -s /usr/lib/libSDL-1.2.so.0 ${DEST}/${GAMETYPE}/System/libSDL-1.2.so.0
    sudo ln -s /usr/lib/libopenal.so.1 ${DEST}/${GAMETYPE}/System/openal.so
    ### UPDATE
    if [ ! -f "${EXTRAS}/ut2004-lnxpatch3369-2.tar.bz2" ]
    then
       echo "Downloading update 3369 (21MB)"
       wget -q http://downloads.unrealadmin.org/UT2004/Patches/Linux/ut2004-lnxpatch3369-2.tar.bz2 
       echo "Extracting update"
       tar jxf ut2004-lnxpatch3369-2.tar.bz2 > /dev/null
       cd UT2004-Patch
       echo "Updating"
       sudo cp -R * ${DEST}/${GAMETYPE}/
    fi
    ### Write CDKEY file
    echo "Enter your CDKEY (i.e. XXXXX-XXXXX-XXXXX-XXXXX) followed by [ENTER]:"
    read CDKEY
    touch "/home/`whoami`/.ut2004/System/cdkey"
    echo ${CDKEY} > "/home/`whoami`/.ut2004/System/cdkey"
    ### UT Launch Script
        echo "Creating Launch Script"
	touch ${EXTRAS}/ut2004
	echo "#!/bin/sh" > ${EXTRAS}/ut2004
	echo "UT2004_DATA_PATH=${DEST}/${GAMETYPE}/System" >> ${EXTRAS}/ut2004
	echo "ARCH=`uname -m`" >> ${EXTRAS}/ut2004
	echo "UTCOMMAND=ut2004-bin" >> ${EXTRAS}/ut2004
	echo "" >> ${EXTRAS}/ut2004
	echo "if [ ${ARCH} = x86_64 ];" >> ${EXTRAS}/ut2004
	echo "then" >> ${EXTRAS}/ut2004
	echo "        UTCOMMAND=ut2004-bin-linux-amd64" >> ${EXTRAS}/ut2004
	echo "fi" >> ${EXTRAS}/ut2004
	echo "" >> ${EXTRAS}/ut2004
	echo 'if [ -x ${UT2004_DATA_PATH}/${UTCOMMAND} ]' >> ${EXTRAS}/ut2004
	echo "then" >> ${EXTRAS}/ut2004
	echo '        cd ${UT2004_DATA_PATH}/' >> ${EXTRAS}/ut2004
	echo '        exec ./${UTCOMMAND} $*' >> ${EXTRAS}/ut2004
	echo "fi" >> ${EXTRAS}/ut2004
	sudo mv ${EXTRAS}/ut2004 /usr/bin/
	chmod +x /usr/bin/ut2004
   ### ICON
	if [ ! -f "${DEST}/${GAMETYPE}/System/icon.png" ]
	then
	  echo "Icon is missing grabbing a custom icon"
	  wget -q http://rocketdock.com/images/screenshots/UT2004-Game.png
          echo "Installing icon"
	  sudo mv UT2004-Game.png ${DEST}/${GAMETYPE}/System/icon.png
	fi
   ### LAUNCHER
        echo "Creating Desktop Launcher"
	touch ${EXTRAS}/ut2004.desktop
	echo "[Desktop Entry]" > ${EXTRAS}/ut2004.desktop
	echo "Name=Unreal Tournament 2004" >> ${EXTRAS}/ut2004.desktop
	echo "Comment=Unreal Tournament 2004 is a futuristic first-person shooter computer game designed primarily for online multiplayer gaming. The game also includes a single player mode that mimics multiplayer gaming." >> ${EXTRAS}/ut2004.desktop
	echo "Exec=/usr/bin/ut2004" >> ${EXTRAS}/ut2004.desktop
	echo "Icon=/${DEST}/${GAMETYPE}/System/icon.png" >> ${EXTRAS}/ut2004.desktop
	echo "Terminal=false" >> ${EXTRAS}/ut2004.desktop
	echo "Type=Application" >> ${EXTRAS}/ut2004.desktop
	echo "Categories=Application;Game;" >> ${EXTRAS}/ut2004.desktop
        sudo mv ${EXTRAS}/ut2004.desktop /usr/share/applications/
#############################
# Unreal Gold
#############################
   elif [ ${GAME} = "1" ]; then
    GAMETYPE=UnrealGold
    # Extraction happens here
    extractCOMMON
    permCOMMON
    dirsCOMMON
    ######################################
    # SPECIFIC GAME INSTALLATION OPTIONS
    ######################################
    cd ${EXTRAS}
    if [ ! -f "${EXTRAS}/unrealgold-install-436.run" ]
    then
     wget -q "http://icculus.org/~ravage/unreal/unrealgold/unrealgold-install-436.run"
    fi
    sh ${EXTRAS}/unrealgold-install-436.run --target ugold
    cd ${EXTRAS}/ugold
    mkdir -p ${EXTRAS}/data
    tar xvf data.tar.gz -C ${EXTRAS}/data > /dev/null
    cd ${EXTRAS}/data
    sudo cp -R * ${DEST}/${GAMETYPE}/
   elif [ ${GAME} = "2" ]; then
    GAMETYPE=Unreal2
    echo "${GAMETYPE} does not run on linux"
   fi
  else
   echo "${MEDIA} not found, is the disc in the drive?"
  fi
else
  echo "install unsheild"
fi
echo "Installation Complete"
